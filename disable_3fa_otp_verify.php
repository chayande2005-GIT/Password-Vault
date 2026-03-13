<?php
session_start();
$error = $_SESSION['disable_3fa_otp_error'] ?? '';
unset($_SESSION['disable_3fa_otp_error']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Disable 3FA - OTP Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .otp-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 6rem 2rem 4rem 2rem;
            animation: fadeIn 1s ease;
        }

        .otp-box {
            background-color: var(--card-bg);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .otp-box h2 {
            margin-bottom: 1.5rem;
        }

        .otp-box input {
            width: 100%;
            padding: 0.75rem;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border 0.3s;
        }

        .otp-box input:focus {
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

        .error {
            color: red;
            margin-bottom: 1em;
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

    <section class="otp-container">
        <div class="otp-box">
            <h2>OTP Verification</h2>
            <p>Enter the OTP sent to your registered email to disable 3FA.</p>
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="disable_3fa_otp_check.php" method="post">
                <input type="text" name="otp" placeholder="Enter OTP" required><br>
                <button type="submit" class="animated-btn">Verify</button>
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
