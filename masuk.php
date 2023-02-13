<?php
require 'functions.php';
session_start();

if (isset($_POST["daftar"])) {
    if (tambahUser($_POST) > 0) {
        $_SESSION["daftar"] = true;
    } else {
        $_SESSION["daftar"] = false;
    }
}

if (isset($_POST["masuk"])) {
    if (masuk($_POST, "users")) {
        $_SESSION["masuk"] = $_POST["email"];
        $_SESSION["alertMasuk"] = true;
        header("Location:index.php");
        exit();
    } else {
        $_SESSION["masuk"] = false;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="style/main.css" rel="stylesheet">
</head>
<body>
<div class="container col-xl-10 col-xxl-8 px-4">
    <div class="row align-items-center g-lg-5 h-100vh">
        <div class="col-lg-7">
            <?php if (isset($_SESSION["daftar"])) {
                if ($_SESSION["daftar"]) {
                    echo
                    '<div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                            <strong>Berhasil daftar akun!</strong> Silahkan melakukan login.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>';
                } else {
                    echo
                    '<div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                            <strong>Gagal daftar akun!</strong> Pastikan semuanya terisi dengan benar.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
                unset($_SESSION["daftar"]);
            }

            if (isset($_SESSION["masuk"])) {
                if (!$_SESSION["masuk"]) {
                    echo
                    '<div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                            <strong>Gagal masuk!</strong> Pastikan email dan kata sandi anda sesuai.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
                unset($_SESSION["masuk"]);
            }

            if (isset($_SESSION["belumMasuk"])) {
                echo '
                <div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                    <strong>Masuk terlebih dahulu!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                unset($_SESSION["belumMasuk"]);
            }
            ?>
            <img src="img/undraw_Login_re_4vu2.png" class="d-block mx-lg-auto img-fluid" alt="Login"
                 loading="lazy">
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form class="p-4 p-md-5 border rounded-3 bg-light shadow" method="post">
                <h1 class="display-5 fw-bold mb-4 text-center">MASUK</h1>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                           name="email">
                    <label for="floatingInput">Alamat Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                           name="password">
                    <label for="floatingPassword">Kata Sandi</label>
                </div>
                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" class="form-check-input" value="remember-me" name="remember"> Ingat saya
                    </label>
                </div>
                <button class="w-100 btn btn-lg btn-dark" type="submit" name="masuk">Masuk</button>
                <hr class="my-4">
                <small class="d-block text-muted text-center">Belum punya akun? <a href="" data-bs-toggle="modal"
                                                                                   data-bs-target="#daftar">Daftar</a>.
                </small>
            </form>
        </div>
    </div>
</div>
<div class="container">
    <footer class="mt-5 py-3 border-top">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>
</html>