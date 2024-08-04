<?php
$username = "";
$email = "";
$errors = array();
//connect to the database
$conn = mysqli_connect("localhost", "root", "", "wema");

if (!$conn) {
    echo "Connection Failed";
}
