<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "purity_db");

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>