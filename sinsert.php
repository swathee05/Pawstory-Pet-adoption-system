<?php

$name = isset($_POST['sinputname']) ? $_POST['sinputname'] : '';
$Password = isset($_POST['spass']) ? $_POST['spass'] : '';
$Email = isset($_POST['semail']) ? $_POST['semail'] : '';

if (!empty($name) || !empty($Password) || !empty($Email)) {

    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "pawstory";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT uname FROM signup WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum > 0) {
            echo "Account already exists";
        } else {
            $stmt->close();
            $INSERT = "INSERT INTO signup (uname, pwd, email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sss", $name, $Password, $Email);
            
            if ($stmt->execute()) {
                header("Location: login.html");
                exit();
            } else {
                echo "Account registration failed";
            }
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required ";
    die();
}
?>
