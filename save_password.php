<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in. Please log in first.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $website = trim($_POST['site_name']);
    $url = trim($_POST['site_url']);
    $username = trim($_POST['site_username']);
    $password = trim($_POST['site_password']);

    // Encryption key (store securely in an env file)
    $key = "your_secret_key_32_chars"; 
    $iv = "1234567891011121"; 

    // Encrypt the password using AES-256-CBC
    $encrypted_password = openssl_encrypt($password, "AES-256-CBC", $key, 0, $iv);

    // Insert into database securely
    $stmt = $conn->prepare("INSERT INTO passwords (user_id, site_name, site_url, site_username, site_password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $website, $url, $username, $encrypted_password);
    
    if ($stmt->execute()) {
        $error_message = "Password saved securely! Add another one!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Password - Password Vault</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        .form-container {
            max-width: 500px;
            margin: 4rem auto;
            background-color: var(--card-bg);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        form input {
            width: 100%;
            padding: 0.7rem;
            margin-bottom: 1.2rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        .animated-btn {
            background-color: var(--accent-color);
            border: none;
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .animated-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        footer {
            background-color: var(--card-bg);
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            margin-top: 3rem;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">Password Vault</div>
        <nav>
            <a href="about.php">About</a>
            <a href="home_page.php">Home</a>
            <a href="login.php">Log Out</a>
            <button class="btn-login" onclick="window.location.href='view_passwords.php'">View Passwords</button>
            <button class="btn-theme" onclick="toggleTheme()">Change Theme</button>
        </nav>
    </header>

    <section class="form-container">
        <h2>Save Your Password</h2>
        <form action="save_password.php" method="POST">

            <div class="error">
                <?php 
                // Display the error message
                if(isset($error_message)) { 
                    echo $error_message; 
                } 
                ?>
            </div>

            <input type="text" name="site_name" placeholder="Platform Name" required>
            <input type="url" name="site_url" placeholder="Platform URL" required>
            <input type="text" name="site_username" placeholder="User ID" required>
            <input type="password" name="site_password" placeholder="Login Password" required>
            <button class="animated-btn" type="submit">Save</button>
        </form>
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
    </script>
</body>

</html>

