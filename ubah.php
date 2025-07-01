<?php
session_start();
$i = $_GET["kunci"];

$_SESSION["daftar"][$i] = [
    "nama" => $_POST["namaku"],
    "umur" => $_POST["umurku"]
];

header("location: dashboard.php");

?>