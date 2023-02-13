<?php
session_start();

if (!isset($_SESSION["adminMasuk"])) {
    header("Location: masuk-admin.php");
    exit();
}

require '../functions.php';

if (!isset($_GET["lapor"])) {
    header("Location: tanggapi-laporan.php?lapor=pengaduan");
    exit();
}

if (!isset($_SESSION["filter"])) {
    $_SESSION["filter"] = 'semua';
}

if (isset($_POST["filter"])) {
    $_SESSION["filter"] = $_POST["filter"];
}

if (!isset($_SESSION["cari"])) {
    $_SESSION["cari"] = false;
}

if (isset($_POST["cari"])) {
    $_SESSION["cari"] = $_POST["keyword"];
    $lapor = getLaporan($_GET, $_SESSION["filter"], $_SESSION["cari"]);
    unset($_POST["cari"]);
} else {
    $lapor = getLaporan($_GET, $_SESSION["filter"], $_SESSION["cari"]);
}

$email = $_SESSION["adminMasuk"];
$nama = getData("SELECT nama_depan FROM admin WHERE email = '$email'")[0]["nama_depan"];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Tanggapi Laporan</title>
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
                    <?= $nama; ?>
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

<div class="bg-white mt-lg shadow">
    <div class="container pb-4">
        <h2 class="my-4 pt-2">Daftar Laporan</h2>
        <div class="row justify-content-center my-4">
            <div class="col-lg-8">
                <form method="post" class="d-flex">
                    <div class="input-group">
                        <input class="form-control border-dark bg-light" placeholder="Cari..."
                               value="<?php if ($_SESSION["cari"] !== false) echo $_SESSION["cari"] ?>"
                               name="keyword"
                               aria-label="Cari" aria-describedby="button-cari">
                        <button class="btn btn-dark" type="submit" id="button-cari" name="cari">Cari</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-8 col-sm-10">
                <form method="post" class="filter owl-carousel owl-theme">
                    <button type="submit" name="filter" value="semua"
                            class="btn btn-sm
                            <?= (($_SESSION["filter"] == 'semua') ? "btn-dark" : "btn-outline-dark") ?>">
                        Semua
                    </button>
                    <button type="submit" name="filter" value="direspon"
                            class="btn btn-sm
                            <?= (($_SESSION["filter"] == 'direspon') ? "btn-dark" : "btn-outline-dark") ?>">
                        Sudah Direspon
                    </button>
                    <button type="submit" name="filter" value="belum-direspon"
                            class="btn btn-sm
                            <?= (($_SESSION["filter"] == 'belum-direspon') ? "btn-dark" : "btn-outline-dark") ?>">
                        Belum Direspon
                    </button>
                </form>
            </div>
            <form method="post" class="col-4 col-sm-2">
                <select class="form-select form-select-sm border-dark" aria-label="urutkan">
                    <option value="1" class="text-small" selected>Terlama</option>
                    <option value="2" class="text-small">Terbaru</option>
                </select>
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
                <div class="position-relative card ' . (($item["id_tanggapan"] !== null) ? "is-response" : "") . '">
                    <div class="card-header d-flex justify-content-between">
                        <span>Pengaduan</span>
                        <span>' . (($item["id_tanggapan"] !== null) ? "Sudah direspon" : "Belum direspon") . '</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">' . $item["judul"] . '</h5>
                        <a href="rincian-laporan.php?lapor=' . $_GET["lapor"] . '&id=' . $item["id"] . '" 
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
<script>
    $('.filter.owl-carousel').owlCarousel({
        margin: 10,
        autoWidth: true,
    })
</script>
</body>
</html>