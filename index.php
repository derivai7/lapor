<?php
require 'functions.php';
session_start();

if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
    ingatSaya($_COOKIE['id'], $_COOKIE['key']);
}

if (isset($_POST["daftar"])) {
    $tambahUser = tambahUser($_POST);
    if (is_int($tambahUser) && $tambahUser > 0) {
        $_SESSION["daftar"] = true;
        header("Location: masuk.php");
        exit();
    }
}

$nama = '';
if (isset($_SESSION["masuk"])) {
    $email = $_SESSION["masuk"];
    $nama = getData("SELECT nama_depan FROM users WHERE email = '$email'")[0]["nama_depan"];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LAPOR PNG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="style/main.css" rel="stylesheet">
</head>
<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-smooth-scroll="true" tabindex="0">
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
                    <a class="nav-link active" aria-current="page" href="#tentang">TENTANG</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#lapor">LAPOR</a>
                </li>
            </ul>
            <div class="d-flex gap-3 navbar-nav my-3">
                <?php
                if (isset($_SESSION["masuk"])) {
                    if ($_SESSION["masuk"] !== false) {
                        echo '
                        <div class="dropdown">
                            <button class="btn dropdown-toggle d-block w-100" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="far fa-user-circle fs-6 pe-1"></i>'
                            . $nama .
                            '</button>
                            <ul class="dropdown-menu shadow">
                                <li><a class="dropdown-item" href="laporan-saya.php">Laporan Saya</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="ubah-profil.php">Ubah Profil</a></li>
                                <li><a class="dropdown-item" href="ubah-password.php">Ubah Kata Sandi</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="keluar.php" data-bs-toggle="modal" 
                                    data-bs-target="#keluar">
                                        <i class="fas fa-sign-out-alt pe-1"></i>Keluar
                                    </a>
                                </li>
                            </ul>
                        </div>';
                    }
                } else {
                    echo '
                    <a class="btn btn-outline-dark" role="button" href="masuk.php">Masuk</a>
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#daftar">
                        Daftar
                    </button>';
                }
                ?>
            </div>
        </div>
    </div>
</nav>

<div class="bg-aqua">
    <div class="container px-4 py-5 h-100vh d-flex">
        <div class="row flex-lg-row-reverse align-items-center">
            <div class="col-10 col-sm-8 col-lg-6 mx-auto">
                <img src="img/undraw_Online_test_re_kyfx.png" class="img-fluid" alt="Data Reports"
                     loading="lazy">
            </div>
            <div class="col-lg-6">
                <?php if (isset($tambahUser)) {
                    if (is_array($tambahUser)) {
                        echo
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal daftar akun!</strong> ' . $tambahUser["salah"] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } elseif ($tambahUser == 0) {
                        echo
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal daftar akun!</strong> Pastikan semuanya terisi dengan benar.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                } ?>
                <h1 class="display-5 fw-bold mb-4">Layanan Aspirasi dan Pengaduan Online Masysarakat Ponorogo</h1>
                <div class="d-md-flex">
                    <a href="#tentang" role="button" class="btn btn-dark btn-lg px-4 me-md-2">Jelajahi<i
                                class="fas fa-chevron-down ms-2 fs-6"></i></a>
                    <a href="#lapor" role="button" class="btn btn-outline-dark btn-lg px-4">Lapor</a>
                </div>
            </div>
        </div>
    </div>
    <img src="img/wave.svg" alt="Wave">
</div>

<div id="tentang" class="container px-4 py-3">
    <div class="row flex-lg-row align-items-center">
        <div class="col-10 col-sm-8 col-lg-6">
            <img src="img/undraw_Profile_re_4a55.png" class="d-block mx-lg-auto img-fluid" alt="Data Reports"
                 loading="lazy">
        </div>
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold mb-4">Tentang LAPOR PNG</h1>
            <div class="mx-auto">
                <p class="lead mb-4">Pengelolaan pengaduan pelayanan publik di Ponorogo ini belum terkelola secara
                    efektif dan terintegrasi. Masyarakat Ponorogo masih sulit dalam menyampaikan pengaduan atau
                    aspirasinya. Dengan adanya website ini Masyarakat Ponorogo dengan mudah dapat menyalurkan aduannya
                    atau aspirasinya dengan menggunakan website ini.</p>
            </div>
        </div>
    </div>
</div>

<div id="lapor" class="container px-4 py-5">
    <div class="shadow-lg p-3 mb-5 bg-body rounded">
        <h1 class="display-5 my-4 fw-bold text-center">Sampaikan Laporan Anda</h1>
        <?php

        if (isset($_POST["lapor"])) {
            if (isset($_SESSION["masuk"])) {
                $_POST["email"] = $_SESSION["masuk"];
                $_POST["bukti_gambar"] = $_FILES;
                $kirimLaporan = kirimLaporan($_POST);
                if (is_int($kirimLaporan) && $kirimLaporan > 0) {
                    echo
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil mengirim laporan!</strong> <a href="laporan-saya.php">lihat laporan</a>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } elseif (is_array($kirimLaporan)) {
                    echo
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal mengirim laporan!</strong> ' . $kirimLaporan["salah"] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } else {
                    echo
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Gagal mengirim laporan!</strong> Pastikan semuanya terisi dengan benar.
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            } else {
                $_SESSION["belumMasuk"] = true;
                header("Location: masuk.php");
                exit();
            }
        } ?>
        <form enctype="multipart/form-data" action="#lapor" method="post" name="formLaporan">
            <div class="mb-3">
                <label for="klarifikasiLaporan" class="form-label fw-bold">Klarifikasi Laporan</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="klarifikasi" id="pengaduan"
                           value="pengaduan"
                           checked>
                    <label class="form-check-label" for="pengaduan">
                        Pengaduan
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="klarifikasi" id="aspirasi"
                           value="aspirasi">
                    <label class="form-check-label" for="aspirasi">
                        Aspirasi
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label fw-bold">Judul Laporan</label>
                <input class="form-control" name="judul" id="judul" aria-describedby="judul"
                       placeholder="Ketik Judul Laporan Anda *" required>
            </div>
            <div class="mb-3">
                <label for="isi" class="form-label fw-bold">Isi Laporan</label>
                <textarea class="form-control" name="isi" id="isi" rows="3"
                          placeholder="Ketik Isi Laporan Anda *" required></textarea>
            </div>
            <div class="isComplaint">
                <div class="mb-3">
                    <label for="gambar" class="form-label fw-bold">Unggah Bukti Gambar</label>
                    <input type="file" class="form-control" name="bukti_gambar" id="gambar"
                           aria-describedby="gambar">
                </div>
                <div class="mb-3">
                    <label for="lokasi" class="form-label fw-bold">Lokasi Kejadian</label>
                    <input class="form-control" name="lokasi" id="lokasi" aria-describedby="lokasiKejadian"
                           placeholder="Ketik Lokasi Kejadian">
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label fw-bold">Tanggal Kejadian</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" value=""
                           aria-describedby="tanggalKejadian">
                </div>
            </div>
            <button type="submit" name="lapor" class="btn btn-dark d-block mb-4">LAPOR</button>
        </form>
    </div>
</div>

<div class="container">
    <footer class="py-3 border-top">
        <p class="text-center text-muted">&copy; 2022, Design and Develop By Bahtiar Rifa'i</p>
    </footer>
</div>

<div class="modal fade" id="daftar" data-bs-backdrop="static" tabindex="-1" aria-labelledby="daftar"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fw-bold mb-0 fs-2" id="exampleModalLabel">Daftar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="firstname" class="form-label">Nama Depan</label>
                            <input class="form-control" name="firstname" id="firstname" placeholder="Nama Depan *"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Nama Belakang</label>
                            <input class="form-control" name="lastname" id="lastname" placeholder="Nama Belakang *"
                                   required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control" name="email" id="email" placeholder="Massukkan Alamat Email Anda *"
                               required>
                    </div>
                    <div class="mt-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="Massukkan Kata Sandi Anda *"
                               required minlength="8" maxlength="20">
                        <div id="passwordHelpBlock" class="form-text">
                            Kata sandi Anda harus sepanjang 8-20 karakter.
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="date-of-birth" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="date-of-birth" id="date-of-birth"
                               placeholder="Masukkan Tanggal Lahir Anda *" required>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="Laki-laki" id="male"
                                   checked>
                            <label class="form-check-label" for="male">
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="Perempuan" id="female"
                                   required>
                            <label class="form-check-label" for="female">
                                Perempuan
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="daftar" class="btn btn-dark">Daftar</button>
                </div>
            </form>
        </div>
    </div>
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
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/script.js"></script>
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