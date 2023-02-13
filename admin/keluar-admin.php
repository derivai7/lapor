<?php
session_start();

unset($_SESSION["adminMasuk"]);

setcookie('id', '', time()-3600);
setcookie('key', '', time()-3600);

header("Location: index.php");
exit();