<?php
require 'connect.php';
require_once 'C:\xampp\htdocs\Vault\vendor\autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error_message = "Error: Both fields are required.";
    }

    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    if ($_SESSION['login_attempts'] >= 5) {
        $error_message = "Too many failed attempts. Try again later.";
    }

    // Secure prepared statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        
        // Generate OTPs
        $email_otp = rand(100000, 999999);

        // Store OTPs in pending_logins
        $stmt2 = $conn->prepare("INSERT INTO pending_logins (user_id, email_otp) VALUES (?, ?)");
        $stmt2->bind_param("is", $user['id'], $email_otp);
        $stmt2->execute();
        $pending_login_id = $stmt2->insert_id;
        $stmt2->close();

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
         $mail->addAddress($user['email']);;

        $mail->isHTML(true);
        $mail->Subject = 'Your Login OTP';
        // Fetch user's name
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
        $mail->Body    = "Hi " . htmlspecialchars($username) . ",<br><br>We are glad to have you with us! Use your OTP : <b>$email_otp</b> for login. Don't share it with anyone. If you didn't request this, please ignore this email.<br><br>Regards,<br>Password Vault Team";

        $mail->send();
    } catch (Exception $e) {
        echo "Email sending failed. Error: {$mail->ErrorInfo}";
    }
        
            // Store pending_login_id in session
            $_SESSION['pending_login_id'] = $pending_login_id;

            // Redirect to OTP verification page
            header("Location: login_otp_verify.php");
            exit();
        } else {
            $_SESSION['login_attempts']++;
            $error_message = "Invalid username or password.";
        }
    } else{
        // show error if no user found
        $error_message = "Invalid username or password.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Vault - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>

        html {
            height: 100%;
        }

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
            height: 100%;
            transition: all 0.4s ease;
            display: flex;
            flex-direction: column;
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

        .login-container {
            flex: 1; /* allow it to grow and push footer */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 6rem 2rem 4rem 2rem;
            animation: fadeIn 1s ease;
        }

        .login-box {
            background-color: var(--card-bg);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 1.5rem;
        }

        .login-box input {
            width: 100%;
            padding: 0.75rem;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border 0.3s;
        }

        .login-box input:focus {
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
            background-color: darken(var(--accent-color), 10%);
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
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
            <button class="btn-login" onclick="window.location.href='registration.php'">Sign Up</button>
            <button class="btn-theme" onclick="toggleTheme()">Change Theme</button>
        </nav>
    </header>

    <section class="login-container">
        <div class="login-box">
            <h1>Welcome Back!</h1>
            <p>Securely access your password vault.</p>
            <form action="login.php" method="POST">
                
                <input type="username" name="username" placeholder="User Name" required>
                <input type="password" name="password" placeholder="Password" required>
                New here?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="registration.php">Create new account</a><br>
                <button type="submit" class="animated-btn">Log In</button>

                

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
            } else if (currentTheme === 'light' || currentTheme === null) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        }
    </script>
</body>

</html>
