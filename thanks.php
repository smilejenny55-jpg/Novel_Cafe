<?php
// Check if data was actually sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Safely collect the data from the form
    $name = htmlspecialchars($_POST['user_name']);
    $email = htmlspecialchars($_POST['user_email']);
    $message = htmlspecialchars($_POST['user_message']);
} else {
    // If someone tries to access this page directly without posting, send them back
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Received | Novel Coffee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #F9F5F2; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); max-width: 500px; width: 95%; text-align: center; }
        .icon { font-size: 50px; color: #28a745; margin-bottom: 20px; }
        h1 { color: #6F4E37; margin: 0; }
        .details-box { text-align: left; background: #fafafa; border: 1px solid #eee; padding: 20px; border-radius: 10px; margin: 25px 0; }
        .details-box p { margin: 10px 0; color: #444; border-bottom: 1px solid #f0f0f0; padding-bottom: 5px; }
        .label { font-weight: bold; color: #D27D2D; display: inline-block; width: 80px; }
        .back-btn { background: #6F4E37; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="card">
        <i class="fa-solid fa-circle-check icon"></i>
        <h1>Thank You, <?php echo $name; ?>!</h1>
        <p>Your message has been received. Here are the details you sent:</p>

        <div class="details-box">
            <p><span class="label">Name:</span> <?php echo $name; ?></p>
            <p><span class="label">Email:</span> <?php echo $email; ?></p>
            <p><span class="label">Message:</span> <?php echo nl2br($message); ?></p>
        </div>

        <p style="margin-bottom: 30px; color: #888;">We will contact you at <b><?php echo $email; ?></b> very soon.</p>
        
        <a href="index.html" class="back-btn">Return to Home</a>
    </div>

</body>
</html>