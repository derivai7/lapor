<?php

$conn = mysqli_connect("localhost", "root", "", "lapor");

if (!$conn) {
    die('Koneksi Error: ' . mysqli_connect_errno() . ' - ' . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM users");

function getData($query): array
{
    global $conn;
    $result = mysqli_query($conn, $query);

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function cekEmailSama($email): bool
{
    $results = getData("SELECT email FROM users;");
    foreach ($results as $result) {
        if ($result["email"] === $email) {
            return true;
        }
    }
    return false;
}

function tambahUser($data): array|bool|int|string
{
    global $conn;

    $email = $data["email"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    if (cekEmailSama($email)) {
        return array("salah" => "Email tersebut sudah ada");
    }

    $namaDepan = htmlspecialchars($data["firstname"]);
    $namaBelakang = htmlspecialchars($data["lastname"]);
    $password = htmlspecialchars($data["password"]);
    $tanggalLahir = $data["date-of-birth"];
    $jenisKelamin = $data["gender"];

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (nama_depan, nama_belakang, email, kata_sandi, tanggal_lahir, jenis_kelamin) VALUES
            ('$namaDepan', '$namaBelakang', '$email', '$password', '$tanggalLahir', '$jenisKelamin')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function masuk($data, $table): bool
{
    global $conn;

    $email = $data["email"];
    $password = $data["password"];

    $ingatSaya = $data["remember"] ?? null;

    $result = mysqli_query($conn, "SELECT * FROM $table WHERE email ='$email'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["kata_sandi"])) {

            if ($ingatSaya !== null) {
                setcookie('id', $row['id'], time() + 60);
                setcookie('key', hash("sha256", $row['email']), time() + 60);
            }

            return true;
        }

    }
    return false;
}

function ingatSaya($id, $key): void
{
    global $conn;

    $result = mysqli_query($conn, "SELECT email FROM users WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash('sha256', $row["email"])) {
        $_SESSION["masuk"] = $row["email"];
    }
}

function ubahProfil($data, $table): int|string
{
    global $conn;

    $email = $data["email"];
    $namaDepan = htmlspecialchars($data["firstname"]);
    $namaBelakang = htmlspecialchars($data["lastname"]);
    $tanggalLahir = $data["date-of-birth"];
    $jenisKelamin = $data["gender"];

    $query = "
                UPDATE $table
                SET nama_depan    = '$namaDepan',
                    nama_belakang = '$namaBelakang',
                    tanggal_lahir = '$tanggalLahir',
                    jenis_kelamin = '$jenisKelamin'
                WHERE email = '$email'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubahKataSandi($data, $table): bool|int|string
{
    global $conn;

    $email = $data["email"];
    $password_lama = htmlspecialchars($data["old-password"]);

    $result = mysqli_query($conn, "SELECT kata_sandi FROM $table WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password_lama, $row["kata_sandi"])) {
        $password_baru = password_hash($data["new-password"], PASSWORD_DEFAULT);

        $query = "
                    UPDATE $table
                    SET kata_sandi = '$password_baru'
                    WHERE email = '$email'";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }
    return false;
}

function buktiGambar($data): array|string
{
    $namaFile = $_FILES["bukti_gambar"]["name"];
    $ukuranFile = $_FILES["bukti_gambar"]["size"];
    $tmpName = $_FILES["bukti_gambar"]["tmp_name"];
    $gambarValid = ['jpg', 'jpeg', 'png', 'webp', 'heif'];
    $formatGambar = explode('.', $namaFile);
    $formatGambar = strtolower(end($formatGambar));

    if (!in_array($formatGambar, $gambarValid)) {
        return array("salah" => "Yang anda upload bukan gambar.");
    } elseif ($ukuranFile > 1000000) {
        return array("salah" => "Ukuran gambar terlalu besar.");
    }

    $NAMAFINAL = $data["email"] . '(' . time() . ').' . $formatGambar;
    move_uploaded_file($tmpName, 'img/laporan/' . $NAMAFINAL);
    return $NAMAFINAL;
}

function kirimLaporan($data): int|array|string
{
    global $conn;

    $klarifikasi = $data["klarifikasi"];
    $judul = $data["judul"];
    $isi = $data["isi"];
    $email = $data["email"];

    $result = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);

    $id = $row["id"];

    if ($klarifikasi === "pengaduan") {
        $lokasi = $data["lokasi"];
        $tanggal = $data["tanggal"];
        $gambar = '';

        if ($tanggal === '') {
            $tanggal = date("Y-m-d");
        }

        if (isset($data["bukti_gambar"])) {
            $gambar = buktiGambar($data);

            if (is_array($gambar)) {
                return $gambar;
            }
        }

        $query = "
                INSERT INTO pengaduan (judul, isi, lokasi_kejadian, tanggal_kejadian, bukti_gambar, user_id)
                VALUES ('$judul', '$isi', '$lokasi', '$tanggal', '$gambar', '$id');
        ";
    } else {
        $query = "
                INSERT INTO aspirasi (judul, isi, user_id)
                VALUES ('$judul', '$isi', '$id');
        ";
    }

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function getLaporan($data, $filter, $search): array
{
    $query = "";

    if ($data["lapor"] == 'pengaduan') {
        if ($filter == 'semua') {
            if (!$search) {
                $query = "
                SELECT p.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_pengaduan
                FROM pengaduan p
                         LEFT JOIN tanggapan t ON p.id = t.id_pengaduan;";
            } else {
                $query = "
                SELECT p.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_pengaduan
                FROM pengaduan p
                         LEFT JOIN tanggapan t ON p.id = t.id_pengaduan
                WHERE judul LIKE '%$search%';";
            }
        } elseif ($filter == 'direspon') {
            if (!$search) {
                $query = "
                SELECT p.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_pengaduan
                FROM pengaduan p
                         JOIN tanggapan t ON p.id = t.id_pengaduan;";
            } else {
                $query = "
                SELECT p.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_pengaduan
                FROM pengaduan p
                         JOIN tanggapan t ON p.id = t.id_pengaduan
                WHERE judul LIKE '%$search%';";
            }
        } elseif ($filter == 'belum-direspon') {
            if (!$search) {
                $query = "
                SELECT p.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_pengaduan
                FROM pengaduan p
                         LEFT JOIN tanggapan t ON p.id = t.id_pengaduan
                WHERE t.id IS NULL
                    AND id_pengaduan IS NULL;";
            } else {
                $query = "
                SELECT p.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_pengaduan
                FROM pengaduan p
                         LEFT JOIN tanggapan t ON p.id = t.id_pengaduan
                WHERE t.id IS NULL
                    AND id_pengaduan IS NULL AND judul LIKE '%$search%';";
            }
        }
    } elseif ($data["lapor"] == 'aspirasi') {
        if ($filter == 'semua') {
            if (!$search) {
                $query = "
                SELECT a.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_aspirasi
                FROM aspirasi a
                         LEFT JOIN tanggapan t ON a.id = t.id_aspirasi;";
            } else {
                $query = "
                SELECT a.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_aspirasi
                FROM aspirasi a
                         LEFT JOIN tanggapan t ON a.id = t.id_aspirasi
                WHERE judul LIKE '%$search%';";
            }
        } elseif ($filter == 'direspon') {
            if (!$search) {
                $query = "
                SELECT a.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_aspirasi
                FROM aspirasi a
                         JOIN tanggapan t ON a.id = t.id_aspirasi;";
            } else {
                $query = "
                SELECT a.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_aspirasi
                FROM aspirasi a
                         JOIN tanggapan t ON a.id = t.id_aspirasi
                WHERE judul LIKE '%$search%';";
            }
        } elseif ($filter == 'belum-direspon') {
            if (!$search) {
                $query = "
                SELECT a.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_aspirasi
                FROM aspirasi a
                         LEFT JOIN tanggapan t ON a.id = t.id_aspirasi
                WHERE t.id IS NULL
                    AND id_aspirasi IS NULL;";
            } else {
                $query = "
                SELECT a.id,
                       judul,
                       tanggal_lapor,
                       t.id AS 'id_tanggapan',
                       id_aspirasi
                FROM aspirasi a
                         LEFT JOIN tanggapan t ON a.id = t.id_aspirasi
                WHERE t.id IS NULL
                    AND id_aspirasi IS NULL AND judul LIKE '%$search%';";
            }
        }
    }

    return getData($query);
}

function detailLaporan($data): array
{
    $id = $data["id"];
    $query = '';
    if ($data["lapor"] == 'pengaduan') {
        $query = "
        SELECT judul,
               isi,
               tanggal_kejadian,
               lokasi_kejadian,
               bukti_gambar,
               u.nama_depan    AS 'nama_depan_user',
               u.nama_belakang AS 'nama_belakang_user',
               u.email         AS 'email_user',
               tanggal_lapor,
               t.id            AS 'id_tanggapan',
               t.tanggapan,
               a.nama_depan    AS 'nama_depan_admin',
               a.nama_belakang AS 'nama_belakang_admin',
               dibaca_pengguna
        FROM pengaduan p
                 JOIN users u ON p.user_id = u.id
                 LEFT JOIN tanggapan t ON p.id = t.id_pengaduan
                 LEFT JOIN admin a ON t.id_admin = a.id
        WHERE p.id = $id
          AND t.id_aspirasi IS NULL;";
    } elseif ($data["lapor"] == 'aspirasi') {
        $query = "
        SELECT judul,
               isi,
               u.nama_depan     AS 'nama_depan_user',
               u.nama_belakang  AS 'nama_belakang_user',
               u.email          AS 'email_user',
               tanggal_lapor,
               t.id             AS 'id_tanggapan',
               t.tanggapan,
               a2.nama_depan    AS 'nama_depan_admin',
               a2.nama_belakang AS 'nama_belakang_admin',
               dibaca_pengguna
        FROM aspirasi a
                 JOIN users u ON a.user_id = u.id
                 LEFT JOIN tanggapan t ON a.id = t.id_aspirasi
                 LEFT JOIN admin a2 ON t.id_admin = a2.id
        WHERE a.id = $id
          AND t.id_pengaduan IS NULL;";
    }

    return getData($query);
}

function beriTanggapan($data): int|string
{
    global $conn;

    $id = $data["id"];
    $isi = $data["isi"];
    $id_admin = $data["id_admin"];

    $query = '';
    if ($data["lapor"] == 'pengaduan') {
        $query = "
            INSERT INTO tanggapan (id_pengaduan, id_aspirasi, tanggapan, id_admin)
            VALUES ($id, NULL, '$isi', $id_admin);";
    } else {
        $query = "
            INSERT INTO tanggapan (id_pengaduan, id_aspirasi, tanggapan, id_admin)
            VALUES (NULL, $id, '$isi', $id_admin);";
    }

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function getAdmin(): array
{
    $query = "
    SELECT a.id, nama_depan, nama_belakang, email, tanggal_lahir, jenis_kelamin, COUNT(t.id_admin) AS total_tanggapan
    FROM admin a
             LEFT JOIN tanggapan t ON a.id = t.id_admin
    GROUP BY a.id;";

    return getData($query);
}

function hapus($id): bool|int|string
{
    if (!$id) {
        return false;
    }

    global $conn;
    mysqli_query($conn, "DELETE FROM admin WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function getMyLaporan($id, $filter, $search)
{
    $query = '';

    if ($filter == 'pengaduan') {
        if (!$search) {
            $query = "
            SELECT p.id, judul, tanggal_lapor, t.id AS 'id_tanggapan', dibaca_pengguna
            FROM pengaduan p
                     LEFT JOIN tanggapan t ON p.id = t.id_pengaduan
            WHERE user_id = $id;";
        } else {
            $query = "
            SELECT p.id, judul, tanggal_lapor, t.id AS 'id_tanggapan', dibaca_pengguna
            FROM pengaduan p
                     LEFT JOIN tanggapan t ON p.id = t.id_pengaduan
            WHERE user_id = $id AND judul LIKE '%$search%';";
        }
    } elseif ($filter == 'aspirasi') {
        if (!$search) {
            $query = "
            SELECT a.id, judul, tanggal_lapor, t.id AS 'id_tanggapan', dibaca_pengguna
            FROM aspirasi a
                     LEFT JOIN tanggapan t ON a.id = t.id_aspirasi
            WHERE user_id = $id;";
        } else {
            $query = "
            SELECT a.id, judul, tanggal_lapor, t.id AS 'id_tanggapan', dibaca_pengguna
            FROM aspirasi a
                     LEFT JOIN tanggapan t ON a.id = t.id_aspirasi
            WHERE user_id = $id AND judul LIKE '%$search%';";
        }
    }

    return getData($query);
}

function dibaca($id, $table): void
{
    global $conn;

    $query = "
    UPDATE tanggapan
    SET dibaca_pengguna = TRUE
    WHERE id_" . $table . " = $id;";

    mysqli_query($conn, $query);
}
