<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $sql = "INSERT INTO submissions (name, email, message)
            VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        header("Location: thanks.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
