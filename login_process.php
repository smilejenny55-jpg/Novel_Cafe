<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user["password"])) {
            echo "<script>alert('Login successful'); window.location='index.html';</script>";
        } else {
            echo "<script>alert('Incorrect password'); window.location='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.location='login.html';</script>";
    }
}
?>
