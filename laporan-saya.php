<?php
session_start();

if (!isset($_SESSION["masuk"])) {
    header("Location: index.php");
    exit();
}

require 'functions.php';

$email = $_SESSION["masuk"];
$user = getData("SELECT id, nama_depan FROM users WHERE email = '$email'")[0];

if (!isset($_SESSION["klarifikasi"])) {
    $_SESSION["klarifikasi"] = 'pengaduan';
}

if (isset($_POST["klarifikasi"])) {
    $_SESSION["klarifikasi"] = $_POST["klarifikasi"];
}

if (!isset($_SESSION["cariLaporanSaya"])) {
    $_SESSION["cariLaporanSaya"] = false;
}

if (isset($_POST["cariLaporanSaya"])) {
    $_SESSION["cariLaporanSaya"] = $_POST["keyword"];
    $lapor = getMyLaporan($user["id"], $_SESSION["klarifikasi"], $_SESSION["cariLaporanSaya"]);
    unset($_POST["cariLaporanSaya"]);
} else {
    $lapor = getMyLaporan($user["id"], $_SESSION["klarifikasi"], $_SESSION["cariLaporanSaya"]);
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
                        <li><a class="dropdown-item active" href="laporan-saya.php">Laporan Saya</a></li>
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

<div class="bg-white mt-lg shadow">
    <div class="container pb-4">
        <h2 class="my-4 pt-2">Daftar Laporan</h2>
        <div class="row">
            <div class="col-6 col-sm-9">
                <form method="post" class="filter owl-carousel owl-theme">
                    <button type="submit" name="klarifikasi" value="pengaduan"
                            class="btn <?= (($_SESSION["klarifikasi"] == 'pengaduan') ? "btn-dark" : "btn-outline-dark") ?>">
                        Pengaduan
                    </button>
                    <button type="submit" name="klarifikasi" value="aspirasi"
                            class="btn <?= (($_SESSION["klarifikasi"] == 'aspirasi') ? "btn-dark" : "btn-outline-dark") ?>">
                        Aspirasi
                    </button>
                </form>
            </div>
            <form method="post" class="col-6 col-sm-3">
                <div class="input-group">
                    <input class="form-control border-dark bg-light" placeholder="Cari..."
                           value="<?php if ($_SESSION["cariLaporanSaya"] !== false) echo $_SESSION["cariLaporanSaya"] ?>"
                           name="keyword" aria-label="Cari" aria-describedby="button-cari">
                    <button class="btn btn-dark" type="submit" id="button-cari" name="cariLaporanSaya"><i
                                class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container pt-5">
    <div class="row">
        <?php
        foreach ($lapor as $item) {
            echo '
            <div class="col-md-6 mb-3">
                <div class="position-relative card ' . (($item["id_tanggapan"] !== null) ? "is-response" : "") . '">'
                . (($item["dibaca_pengguna"] == 0 && $item["id_tanggapan"] != null) ?
                    '<span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light 
                    rounded-circle"></span>' : '') .'
                    <div class="card-header d-flex justify-content-between">
                        <span>' . ucfirst($_SESSION["klarifikasi"]) . '</span>
                        <span>' . (($item["id_tanggapan"] !== null) ? "Sudah direspon" : "Belum direspon") . '</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">' . $item["judul"] . '</h5>
                        <a href="rincian-laporan-saya.php?id=' . $item["id"] . '" 
                        class="btn btn-dark">Lihat Rincian</a>
                    </div>
                    <div class="card-footer text-muted">
                        ' . $item["tanggal_lapor"] . '
                    </div>
                </div>
            </div>
            ';
        }
        ?>
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