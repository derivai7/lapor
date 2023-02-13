<?php
session_start();

unset($_SESSION["masuk"]);

setcookie('id', '', time()-3600);
setcookie('key', '', time()-3600);

header("Location: index.php");
exit();