<?php
require '../functions.php';
session_start();

if (isset($_POST["masuk"])) {
    if (masuk($_POST, "admin")) {
        $_SESSION["adminMasuk"] = $_POST["email"];
        $_SESSION["alertMasuk"] = true;
        header("Location:index.php");
        exit();
    } else {
        $_SESSION["adminMasuk"] = false;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="../style/main.css" rel="stylesheet">
</head>
<body>
<div class="container col-xl-10 col-xxl-8 px-4">
    <div class="row align-items-center h-100vh">
        <?php
        if (isset($_SESSION["adminMasuk"])) {
            if (!$_SESSION["adminMasuk"]) {
                echo
                '<div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                            <strong>Gagal masuk!</strong> Pastikan email dan kata sandi anda sesuai.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
            unset($_SESSION["adminMasuk"]);
        }
        ?>
        <div class="col-lg-7">
            <img src="img/undraw_Quitting_time_re_1whp.png" class="d-block mx-lg-auto img-fluid" alt="Login"
                 loading="lazy">
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form class="p-4 p-md-5 border rounded-3 bg-light shadow" method="post">
                <h1 class="display-5 fw-bold text-center lh-1">MASUK</h1>
                <p class="fs-5 text-center mb-4">Sebagai Admin</p>
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
            </form>
        </div>
    </div>
</div>
<div class="container">
    <footer class="mt-5 py-3 border-top">
        <p class="text-center text-muted">&copy; 2022, Design and Develop By Bahtiar Rifa'i</p>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>
</html>