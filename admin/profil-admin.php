<?php
session_start();

if (!isset($_SESSION["adminMasuk"])) {
    header("Location: masuk-admin.php");
    exit();
}

require '../functions.php';

$email = $_SESSION["adminMasuk"];
$admin = getData("SELECT * FROM admin WHERE email = '$email'")[0];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="../style/main.css" rel="stylesheet">
</head>
<body class="h-100vh d-flex flex-column justify-content-between" data-bs-spy="scroll" data-bs-target="#navbar"
      data-bs-smooth-scroll="true" tabindex="0">

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
                    <?= $admin["nama_depan"]; ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item active" href="profil-admin.php">Profil</a></li>
                    <li><a class="dropdown-item" href="ubah-password-admin.php">Ubah Kata Sandi</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="../keluar.php" data-bs-toggle="modal"
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
                    <a class="nav-link text-white dropdown-toggle" href="tanggapi-laporan.php" role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <div class="icon-neat">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        Tanggapi Laporan
                    </a>

                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="tanggapi-laporan.php?lapor=pengaduan">Pengaduan</a></li>
                        <li><a class="dropdown-item" href="tanggapi-laporan.php?lapor=aspirasi">Aspirasi</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-lg">
    <div class="row justify-content-center g-5 mt-2">
        <div class="col-md-3 border-end">
            <ul class="list-group">
                <li class="list-group-item active"><a class="nav-link" href="profil-admin.php">Profil</a></li>
                <li class="list-group-item"><a class="nav-link" href="ubah-password-admin.php">Ubah Kata Sandi</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <form>
                <h4 class="mb-3">Profil</h4>
                <div class="row">
                    <div class="col-md-6">
                        <label for="firstname" class="form-label">Nama Depan</label>
                        <input class="form-control" id="firstname" value="<?= $admin['nama_depan'] ?>" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Nama Belakang</label>
                        <input class="form-control" id="lastname" value="<?= $admin['nama_belakang'] ?>" disabled>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="email" class="form-label">Email</label>
                    <input class="form-control" id="email" value="<?= $admin['email'] ?>" disabled>
                </div>
                <div class="mt-3">
                    <label for="date-of-birth" class="form-label">Tanggal Lahir</label>
                    <input class="form-control" id="date-of-birth" value="<?= $admin['tanggal_lahir'] ?>" disabled>
                </div>
                <div class="mt-3">
                    <label for="jenis-kelamin" class="form-label">Jenis Kelamin</label>
                    <input class="form-control" id="jenis-kelamin" value="<?= $admin['jenis_kelamin'] ?>" disabled>
                </div>
            </form>
        </div>
    </div>
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
</body>
</html>