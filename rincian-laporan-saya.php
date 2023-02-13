<?php
session_start();

if (!isset($_SESSION["masuk"])) {
    header("Location: index.php");
    exit();
}

require 'functions.php';

if (!isset($_GET["id"])) {
    header("Location: laporan-saya.php");
    exit();
} else {
    $data["id"] = $_GET["id"];
    $data["lapor"] = $_SESSION["klarifikasi"];
    $item = detailLaporan($data)[0];
}

if ($item["dibaca_pengguna"] == 0 && $item["id_tanggapan"] != null) {
    dibaca($_GET["id"], $_SESSION["klarifikasi"]);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
          rel="stylesheet"/>
    <link href="style/main.css" rel="stylesheet">
</head>
<body class="h-100vh d-flex flex-column justify-content-between" data-bs-spy="scroll" data-bs-target="#navbar"
      data-bs-smooth-scroll="true" tabindex="0">
<nav id="navbar" class="navbar navbar-expand-lg fixed-top bg-light shadow">
    <div class="container px-4">
        <span class="navbar-brand fw-bold">LAPOR PNG</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php#tentang">TENTANG</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#lapor">LAPOR</a>
                </li>
            </ul>
            <div class="d-flex gap-3 navbar-nav my-3">
                <div class="dropdown">
                    <button class="btn dropdown-toggle d-block w-100" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        <i class="far fa-user-circle fs-6 pe-1"></i>
                        Bahtiar
                    </button>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item active" href="ubah-profil.php">Laporan Saya</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="ubah-profil.php">Ubah Profil</a></li>
                        <li><a class="dropdown-item" href="ubah-password.php">Ubah Kata Sandi</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="keluar.php"><i
                                        class="fas fa-sign-out-alt pe-1"></i>Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="bg-white container mt-lg shadow rounded pb-4">
    <form class="container">
        <h2 class="my-4 pt-2">Rincian Laporan</h2>
        <div class="mb-3 row border-bottom">
            <label for="klarifikasi" class="col-sm-3 col-form-label fw-bold">Klarifikasi Laporan</label>
            <div class="col-sm-9">
                <input readonly class="form-control-plaintext" id="klarifikasi"
                       value="<?= ucfirst($_SESSION["klarifikasi"]) ?>">
            </div>
        </div>
        <div class="mb-3 row border-bottom">
            <label for="judul" class="col-sm-3 col-form-label fw-bold">Judul Laporan</label>
            <div class="col-sm-9">
                <input readonly class="form-control-plaintext" id="judul" value="<?= $item["judul"] ?>">
            </div>
        </div>
        <div class="mb-3 row border-bottom">
            <label for="isi" class="col-sm-3 col-form-label fw-bold">Isi Laporan</label>
            <div class="col-sm-9">
                <input readonly class="form-control-plaintext" id="isi" value="<?= $item["isi"] ?>">
            </div>
        </div>
        <div class="mb-3 row border-bottom">
            <label for="status" class="col-sm-3 col-form-label fw-bold">Status</label>
            <div class="col-sm-9">
                <input readonly class="form-control-plaintext" id="status"
                       value="<?= (($item["id_tanggapan"] !== null) ? "Sudah ditanggapi" : "Belum direspon") ?>">
            </div>
        </div>
        <?php
        if ($_SESSION["klarifikasi"] == 'pengaduan') {
            echo '
            <div class="mb-3 row border-bottom">
                <label for="gambar" class="col-sm-3 col-form-label fw-bold">Bukti Gambar</label>
                <div class="col-sm-9">' . (($item["bukti_gambar"] != '') ?
                    '<img src="img/laporan/' . $item["bukti_gambar"] . '" 
                    alt="Bukti Gambar" class="mb-3 border" width="200">' : "-") . '
                </div>
            </div>
            <div class="mb-3 row border-bottom">
                <label for="lokasi" class="col-sm-3 col-form-label fw-bold">Lokasi Kejadian</label>
                <div class="col-sm-9">
                    <input readonly class="form-control-plaintext" id="lokasi"
                           value="' . (($item["lokasi_kejadian"] != '') ? $item["lokasi_kejadian"] : "-") . '">
                </div>
            </div>
            <div class="mb-3 row border-bottom">
                <label for="tanggal" class="col-sm-3 col-form-label fw-bold">Tanggal Kejadian</label>
                <div class="col-sm-9">
                    <input readonly class="form-control-plaintext" id="tanggal"
                           value="' . (($item["tanggal_kejadian"] != '') ? $item["tanggal_kejadian"] : "-") . '">
                </div>
            </div>';
        }
        ?>
        <div class="mb-3 row border-bottom">
            <label for="nama" class="col-sm-3 col-form-label fw-bold">Nama Pelapor</label>
            <div class="col-sm-9">
                <input readonly class="form-control-plaintext" id="nama"
                       value="<?= $item["nama_depan_user"] . ' ' . $item["nama_belakang_user"] ?>">
            </div>
        </div>
        <div class="mb-3 row border-bottom">
            <label for="email" class="col-sm-3 col-form-label fw-bold">Email Pelapor</label>
            <div class="col-sm-9">
                <input readonly class="form-control-plaintext" id="email"
                       value="<?= $item["email_user"] ?>">
            </div>
        </div>
        <div class="mb-3 row border-bottom">
            <label for="tanggal_lapor" class="col-sm-3 col-form-label fw-bold">Tanggal Lapor</label>
            <div class="col-sm-9">
                <input readonly class="form-control-plaintext" id="tanggal_lapor"
                       value="<?= $item["tanggal_lapor"] ?>">
            </div>
        </div>
    </form>
    <?php
    if ($item["id_tanggapan"] != null) {
        echo '
        <form class="container">
            <h2 class="my-4 pt-2">Tanggapan</h2>
            <div class="mb-3 row border-bottom">
                <label for="ditanggapi-oleh" class="col-sm-3 col-form-label fw-bold">Ditanggapi Oleh</label>
                <div class="col-sm-9">
                    <input readonly class="form-control-plaintext" id="ditanggapi-oleh"
                           value="' . $item["nama_depan_admin"] . ' ' . $item["nama_belakang_admin"] . ' (Pegawai)">
                </div>
            </div>
            <div class="mb-3 row border-bottom">
                <label for="isi-tanggapan" class="col-sm-3 col-form-label fw-bold">Isi Tanggapan</label>
                <div class="col-sm-9">
                    <textarea class="form-control-plaintext" id="isi-tanggapan"
                              rows="3" readonly>' . $item["tanggapan"] . '</textarea>
                </div>
            </div>
        </form>';
    }
    ?>
</div>

<div class="container">
    <footer class="mt-5 py-3 border-top">
        <p class="text-center text-muted">&copy; 2022, Design and Develop By Bahtiar Rifa'i</p>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/51ab965bab.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        charset="utf-8"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('.filter.owl-carousel').owlCarousel({
        margin: 10,
        autoWidth: true,
    })
</script>
</body>
</html>