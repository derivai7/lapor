<?php
session_start();

if (!isset($_SESSION["adminMasuk"])) {
    header("Location: masuk-admin.php");
    exit();
}

if (!$_GET["id"]) {
    header("Location: daftar-admin.php");
    exit();
}

require 'functions.php';

$id = $_GET["id"];

if (hapus($id) > 0) {
    $_SESSION["hapus"] = $id;
} else {
    $_SESSION["hapus"] = false;
}

echo "<script>document.location.href = 'daftar-admin.php'</script>";
