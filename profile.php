<?php
session_start();
require 'connect.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("SELECT username, email, phone, is_mpin_enabled FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $phone, $is_mpin_enabled);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - Password Vault</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        .profile-box {
            max-width: 500px;
            margin: 4em auto;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            padding: 2em;
            text-align: left;
            transition: background 0.3s;
        }

        .profile-box h2 {
            margin-top: 0;
            margin-bottom: 1em;
            text-align: center;
        }

        .profile-row {
            margin-bottom: 1.2em;
            font-size: 1rem;
        }

        .profile-label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
        }

        .btn-disable {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.95rem;
            transition: transform 0.2s ease;
        }

        .btn-disable:hover {
            transform: scale(1.05);
        }

        .btn-disabled {
            background-color: #999;
            color: #fff;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            cursor: not-allowed;
            font-size: 0.95rem;
        }

        footer {
            background-color: var(--card-bg);
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            margin-top: auto;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">Password Vault</div>
    <nav>
        <a href="home_page.php">Home</a>
        <a href="about.php">About</a>
        <a href="pricing.php">Pricing</a>
        <a href="contact.php">Contacts</a>
        
        <button class="btn-login" onclick="window.location.href='login.php'">Log Out</button>
        <button class="btn-theme" onclick="toggleTheme()">Change Theme</button>
    </nav>
</header>

<div class="profile-box">
    <h2>Your Profile</h2>
    <div class="profile-row"><span class="profile-label">Name:</span> <?= htmlspecialchars($username) ?></div>
    <div class="profile-row"><span class="profile-label">Email:</span> <?= htmlspecialchars($email) ?></div>
    <div class="profile-row"><span class="profile-label">Mobile:</span> <?= htmlspecialchars($phone) ?></div>
    <div class="profile-row">
        <span class="profile-label">3FA (mPIN):</span>
        <?php if ($is_mpin_enabled): ?>
            <span style="color:green;">Enabled</span>
            <button class="btn-disable" onclick="confirmDisable3FA()">Disable 3FA</button>
        <?php else: ?>
            <span style="color:red;">Disabled</span>
            <button class="btn-disabled" disabled>3FA Off</button>
        <?php endif; ?>
    </div>
</div>

<form id="disable3fa-form" action="disable_3fa_request.php" method="post" style="display:none;"></form>

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

    function confirmDisable3FA() {
        if (confirm("Do you really want to disable the 3FA security for your account?")) {
            document.getElementById('disable3fa-form').submit();
        }
    }
</script>

</body>
</html>
