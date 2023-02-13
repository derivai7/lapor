<?php
session_start();

if (!isset($_SESSION["adminMasuk"])) {
    header("Location: masuk-admin.php");
    exit();
}

require '../functions.php';

if (!isset($_GET["lapor"]) or !isset($_GET["id"])) {
    header("Location: tanggapi-laporan.php?lapor=pengaduan");
    exit();
} else {
    $item = detailLaporan($_GET)[0];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Rincian Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
          rel="stylesheet"/>
    <link href="../style/main.css" rel="stylesheet">
</head>
<body class="admin-content h-100vh d-flex flex-column justify-content-between">

<nav class="navbar fixed-top bg-light shadow">
    <div class="container px-4">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                aria-controls="sidebar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="d-flex">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                    <i class="far fa-user-circle fs-6 pe-1"></i>
                    <?= $item["nama_depan_admin"]; ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="profil-admin.php">Profil</a></li>
                    <li><a class="dropdown-item" href="ubah-password-admin.php">Ubah Kata Sandi</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="keluar-admin.php" data-bs-toggle="modal"
                           data-bs-target="#keluar">
                            <i class="fas fa-sign-out-alt pe-1"></i>Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="offcanvas offcanvas-start d-flex flex-column flex-shrink-0 p-3 text-bg-dark" data-bs-scroll="true"
             tabindex="-1" id="sidebar" aria-labelledby="sidebarAdmin">
            <div class="d-flex align-items-center justify-content-between">
                <a href="../index.php" class="fs-4 text-simple fw-bold">LAPOR PNG</a>
                <button class="btn btn-close btn-close-white" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#sidebar"
                        aria-controls="offcanvasWithBothOptions">
                </button>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-1">
                    <a href="index.php" class="nav-link text-white" aria-current="page">
                        <div class="icon-neat">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="daftar-admin.php" class="nav-link text-white" aria-current="page">
                        <div class="icon-neat">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        List Admin
                    </a>
                </li>
                <li class="dropdown nav-item mb-1">
                    <a class="nav-link active dropdown-toggle" href="tanggapi-laporan.php" role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <div class="icon-neat">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        Tanggapi Laporan
                    </a>

                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item <?php if ($_GET["lapor"] == 'pengaduan') echo 'active' ?>"
                               href="tanggapi-laporan.php?lapor=pengaduan">Pengaduan</a>
                        </li>
                        <li><a class="dropdown-item  <?php if ($_GET["lapor"] == 'aspirasi') echo 'active' ?>"
                               href="tanggapi-laporan.php?lapor=aspirasi">Aspirasi</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="bg-white container mt-lg shadow rounded pb-4">
    <?php
    if (isset($_POST["tanggapan"])) {
        $_POST["lapor"] = $_GET["lapor"];
        $_POST["id"] = $_GET["id"];
        $email = $_SESSION['adminMasuk'];
        $_POST["id_admin"] = getData("SELECT id FROM admin WHERE email = '$email'")[0]['id'];

        if (beriTanggapan($_POST) > 0) {
            echo '
            <div class="my-3 alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil memberi tanggapan!</strong>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            echo '
            <div class="my-3 alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal memberi tanggapan!</strong>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    ?>
    <form class="container" method="post">
        <h2 class="my-4 pt-2">Rincian Laporan</h2>
        <div class="mb-3 row border-bottom">
            <label for="klarifikasi" class="col-sm-3 col-form-label fw-bold">Klarifikiasi Laporan</label>
            <div class="col-sm-9">
                <input readonly class="form-control-plaintext" id="klarifikasi" value="<?= ucfirst($_GET["lapor"]) ?>">
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
        if ($_GET["lapor"] == 'pengaduan') {
            echo '
            <div class="mb-3 row border-bottom">
                <label for="gambar" class="col-sm-3 col-form-label fw-bold">Bukti Gambar</label>
                <div class="col-sm-9">' . (($item["bukti_gambar"] != '') ?
                    '<img src="../img/laporan/' . $item["bukti_gambar"] . '" 
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
    if ($item["id_tanggapan"] == null) {
        echo '
        <p>
        <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#tanggapi"
                aria-expanded="false" aria-controls="collapseExample">
            Beri Tanggapan <i class="ps-2 fas fa-angle-down"></i>
        </button>
        </p>
        <div class="collapse" id="tanggapi">
            <div class="card card-body mb-3">
                <form method="post">
                    <div class="mb-3">
                        <label for="isi" class="form-label fw-bold">Isi Tanggapan</label>
                        <textarea class="form-control" name="isi" id="isi" rows="3"
                                  placeholder="Ketik Tanggapan *" required></textarea>
                        <div id="catatan" class="form-text">
                            Catatan: Tanggapan yang sudah dikirim tidak bisa diubah.
                        </div>
                    </div>
                    <button type="submit" name="tanggapan" class="btn btn-dark">Kirim</button>
                </form>
            </div>
        </div>';
    } else {
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

<div class="modal fade" id="keluar" tabindex="-1" aria-labelledby="keluar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Yakin untuk keluar?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Anda tidak bisa mengirim laporan jika keluar.
            </div>
            <div class="modal-footer">
                <a href="keluar-admin.php" role="button" class="btn btn-dark">Keluar</a>
            </div>
        </div>
    </div>
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
</body>
</html>