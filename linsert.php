<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['lemail']) && isset($_POST['lpass'])) {

    function validate($data){
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $lemail = validate($_POST['lemail']);
    $lpass = validate($_POST['lpass']);

    if (empty($lemail)) {
        header("Location: sinsert.php?error=Email is required");
        exit();
    } else if (empty($lpass)) {
        header("Location: sinsert.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT uname, email, pwd FROM signup WHERE email=? AND pwd=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $lemail, $lpass);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['uname'];
            header("Location: index1.html");
            exit();
        } else {
            header("Location: sinsert.php?error=Incorrect username or password");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
