<?php
session_start();

if (!isset($_SESSION["masuk"])) {
    header("Location: index.php");
    exit();
}

require 'functions.php';

$email = $_SESSION["masuk"];
$pengguna = getData("SELECT * FROM users WHERE email = '$email'")[0];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
                        <?= $pengguna["nama_depan"] ?>
                    </button>
                    <ul class="dropdown-menu shadow">
                        <li><a class="dropdown-item" href="laporan-saya.php">Laporan Saya</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item active" href="ubah-profil.php">Ubah Profil</a></li>
                        <li><a class="dropdown-item" href="ubah-password.php">Ubah Kata Sandi</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="keluar.php" data-bs-toggle="modal" data-bs-target="#keluar">
                                <i class="fas fa-sign-out-alt pe-1"></i>Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-lg">
    <div class="row justify-content-center g-5 mt-2">
        <div class="col-md-3 border-end">
            <ul class="list-group">
                <li class="list-group-item active"><a class="nav-link" href="ubah-profil.php">Ubah
                        Profil</a></li>
                <li class="list-group-item"><a class="nav-link" href="ubah-password.php">Ubah Kata Sandi</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <?php if (isset($_POST["ubah-profil"])) {
                $_POST["email"] = $_SESSION["masuk"];
                if (ubahProfil($_POST, 'users') > 0) {
                    echo
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil mengubah data pengguna!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>';
                } else {
                    echo
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal mengubah data pengguna!</strong> Pastikan semuanya terisi dengan benar.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
            } ?>
            <form method="post">
                <h4 class="mb-3">Ubah Profil</h4>
                <div class="row">
                    <div class="col-md-6">
                        <label for="firstname" class="form-label">Nama Depan</label>
                        <input class="form-control" id="firstname" name="firstname"
                               value="<?= $pengguna['nama_depan'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Nama Belakang</label>
                        <input class="form-control" id="lastname" name="lastname"
                               value="<?= $pengguna['nama_belakang'] ?>" required>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="email" class="form-label">Email</label>
                    <input class="form-control" id="email" name="email" value="<?= $pengguna['email'] ?>" disabled>
                </div>
                <div class="mt-3">
                    <label for="date-of-birth" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="date-of-birth" name="date-of-birth"
                           value="<?= $pengguna['tanggal_lahir'] ?>" required>
                </div>
                <div class="mt-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Laki-laki"
                               id="male" <?php if ($pengguna['jenis_kelamin'] == 'Laki-laki') echo 'checked' ?>
                               required>
                        <label class="form-check-label" for="male">
                            Laki-laki
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Perempuan"
                               id="female" <?php if ($pengguna['jenis_kelamin'] == 'Perempuan') echo 'checked' ?>
                               required>
                        <label class="form-check-label" for="female">
                            Perempuan
                        </label>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" name="ubah-profil" class="btn btn-dark">Ubah Profil</button>
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
                <a href="keluar.php" role="button" class="btn btn-dark">Keluar</a>
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