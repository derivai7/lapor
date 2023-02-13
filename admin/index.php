<?php
session_start();

if (!isset($_SESSION["adminMasuk"])) {
    header("Location: masuk-admin.php");
    exit();
}

require '../functions.php';

$email = $_SESSION["adminMasuk"];
$nama = getData("SELECT nama_depan, nama_belakang FROM admin WHERE email = '$email'")[0];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="../style/main.css" rel="stylesheet">
</head>
<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-smooth-scroll="true" tabindex="0">

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
                    <?= $nama["nama_depan"]; ?>
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
                    <a href="index.php" class="nav-link active" aria-current="page">
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
                    <a class="nav-link text-white dropdown-toggle" href="tanggapi-laporan.php" role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <div class="icon-neat">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        Tanggapi Laporan
                    </a>

                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="tanggapi-laporan.php?lapor=pengaduan">Pengaduan</a>
                        </li>
                        <li><a class="dropdown-item" href="tanggapi-laporan.php?lapor=aspirasi">Aspirasi</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="h-100vh d-flex justify-content-center align-items-center flex-column">
    <h1 class="display-5 fw-bold">Halo, Admin<br> <?= $nama["nama_depan"] . ' ' . $nama["nama_belakang"] ?></h1>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/51ab965bab.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($_SESSION["alertMasuk"])) { ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil masuk',
            timer: 5000
        })
    </script>';
    <?php unset($_SESSION["alertMasuk"]);
} ?>
</body>
</html>