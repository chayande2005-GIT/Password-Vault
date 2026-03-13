<?php
require 'connect.php';
require_once 'C:\xampp\htdocs\Vault\vendor\autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error_message = "Password and confirm password do not match !";
    }

    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\\d)(?=.*[@$!%*?&])[A-Za-z\\d@$!%*?&]{10,}$/', $password)) {
        $error_message = "Password must contain at least one number, one special character, and be at least 10 characters long!";
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
    // Check if the user already exists
    // Check for duplicates in users table
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ? OR phone = ?");
        $stmt->bind_param("sss", $username, $email, $phone);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error_message = "Username, email, or phone already exists.";
        }
        $stmt->close();

        // Check for duplicates in pending_registrations table
        if (empty($error_message)) {
            $stmt = $conn->prepare("SELECT id FROM pending_registrations WHERE username = ? OR email = ? OR phone = ?");
            $stmt->bind_param("sss", $username, $email, $phone);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $error_message = "Username, email, or phone is already pending verification.";
            }
            $stmt->close();
        }


    // Generate OTPs
    $email_otp = rand(100000, 999999);

    // Store in pending_registrations
    $stmt = $conn->prepare("INSERT INTO pending_registrations (name, email, phone, password, email_otp) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $phone, $hashed_password, $email_otp);
    $stmt->execute();
    $stmt->close();

    // Send Email OTP
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'passvault2025@gmail.com';         // 🔒 Use your Gmail
        $mail->Password   = 'cofa cfjm vhyq hpnp';       // 🔒 Create App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('passvault2025@gmail.com', 'Password Vault');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Email Verification OTP';
        // Fetch user's name
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
        $mail->Body    = "Welcome " . htmlspecialchars($username) . "!,<br><br>We have successfully got your credentials! Use your OTP : <b>$email_otp</b> to verify your email. Don't share it with anyone. If you didn't request this, please ignore this email.<br><br>Regards,<br>Password Vault Team";

        $mail->send();
    } catch (Exception $e) {
        echo "Email sending failed. Error: {$mail->ErrorInfo}";
    }


    // Store email/phone in session for verification
    $_SESSION['pending_email'] = $email;
    $_SESSION['pending_phone'] = $phone;
    header("Location: register_otp_verify.php");
    exit;

} else {
    // Do not set error message on initial page load
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Vault - Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #ffffff;
            --text-color: #000000;
            --accent-color: #007bff;
            --card-bg: #f0f0f0;
        }

        [data-theme="dark"] {
            --bg-color: #121212;
            --text-color: #ffffff;
            --accent-color: #1e90ff;
            --card-bg: #1e1e1e;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            transition: all 0.4s ease;
        }

        header {
            background-color: var(--card-bg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
        }

        nav a {
            margin: 0 1rem;
            text-decoration: none;
            color: var(--text-color);
            transition: color 0.3s;
        }

        nav a:hover {
            color: var(--accent-color);
        }

        .btn-login, .btn-theme {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            background-color: var(--accent-color);
            color: #fff;
            cursor: pointer;
            margin-left: 1rem;
            transition: transform 0.2s;
        }

        .btn-login:hover, .btn-theme:hover {
            transform: scale(1.05);
        }

        .register-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
            animation: fadeIn 1s ease;
        }

        .register-box {
            background-color: var(--card-bg);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .register-box h2 {
            margin-bottom: 1.5rem;
        }

        .register-box input {
            width: 100%;
            padding: 0.75rem;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border 0.3s;
        }

        .register-box input:focus {
            border-color: var(--accent-color);
        }

        .animated-btn {
            margin-top: 1rem;
            background-color: var(--accent-color);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .animated-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        footer {
            background-color: var(--card-bg);
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">Password Vault</div>
        <nav>
            <a href="about.php">About</a>
            <a href="pricing.php">Pricing</a>
            <a href="contact.php">Contacts</a>
            <button class="btn-login" onclick="window.location.href='login.php'">Sign In</button>
            <button class="btn-theme" onclick="toggleTheme()">Change Theme</button>
        </nav>
    </header>

    <section class="register-container">
        <div class="register-box">
            <h1>Connect With Us !</h1>
            <p>Create your secure account now !!!</p>
            <form onsubmit="return validateForm()" action="registration.php" method="POST">

            <div class="error">
                <?php if (!empty($error_message)): ?>
                    <div style="color: red; margin-top: 1em;"><?= htmlspecialchars($error_message) ?></div>
                <?php endif; ?>
            </div><br>

                <input type="text" name="username" id="username" placeholder="Username" required>
                <input type="tel" name="phone" id="phone" placeholder="Phone Number" required>
                <input type="email" name="email" id="email" placeholder="Email Address" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>
                <div class="error-message" id="error-message"></div>
                Already have an account?&emsp13;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="login.php">Sign In</a><br>
                <button type="submit" class="animated-btn">Register</button>
            </form>
        </div>
    </section>

    <footer>
        &copy; 2025 Password Vault | All rights reserved.
    </footer>

    <script>
        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            if (currentTheme === 'dark') {
                document.documentElement.removeAttribute('data-theme');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        }

        function validateForm() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirmPassword").value;
            const errorDiv = document.getElementById("error-message");

            if (password !== confirmPassword) {
                errorDiv.textContent = "Passwords do not match.";
                return false;
            } else {
                errorDiv.textContent = "";
                return true;
            }
        }
    </script>
</body>

</html>