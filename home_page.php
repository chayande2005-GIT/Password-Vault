<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Vault - Dashboard</title>
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

        .dashboard-container {
            flex: 1;
            padding: 4rem 2rem;
            text-align: center;
        }

        .dashboard-heading {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .dashboard-subheading {
            font-size: 1rem;
            margin-bottom: 2rem;
            color: gray;
        }

        .card-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            width: 300px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .card p {
            font-size: 0.95rem;
            color: gray;
            margin-bottom: 1.5rem;
        }

        .animated-btn {
            background-color: var(--accent-color);
            border: none;
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
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

        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100vw; height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-in-out;
        }
        .modal-content {
            background: white;
            padding: 30px 24px 24px 24px;
            border-radius: 10px;
            width: 320px;
            max-width: 90vw;
            text-align: center;
            position: relative;
            animation: slideDown 0.4s ease-in-out;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        }
        @keyframes fadeIn {
            from {opacity: 0;} to {opacity: 1;}
        }
        @keyframes slideDown {
            from {transform: translateY(-50px); opacity: 0;}
            to {transform: translateY(0); opacity: 1;}
        }
        .close {
            position: absolute;
            top: 10px;
            right: 16px;
            font-size: 24px;
            font-weight: bold;
            color: #888;
            cursor: pointer;
            transition: color 0.2s;
        }
        .close:hover {
            color: #e74c3c;
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
            <a href="profile.php" title="Profile" style="font-size:1.3em;vertical-align:middle;">
                <span style="font-size:1.5em;">👤</span>
            </a>
            <button class="btn-login" onclick="window.location.href='login.php'">Log Out</button>
            <button class="btn-theme" onclick="toggleTheme()">Change Theme</button>
        </nav>
    </header>

    <section class="dashboard-container">
        <div class="dashboard-heading">Securely Store & Access Your Passwords</div>
        <div class="dashboard-subheading">A safe and encrypted way to manage your passwords online.</div>

        <div class="card-wrapper">
            <div class="card">
                <h3>Save Password</h3>
                <p>Store your credentials securely with encryption.</p>
                <button class="animated-btn" onclick="window.location.href='save_password.php'">Save Now</button>
            </div>
            <div class="card">
                <h3>View Saved Passwords</h3>
                <p>Access and manage your stored passwords securely.</p>
                <button class="animated-btn" onclick="window.location.href='view_passwords.php'">View Now</button>
            </div>
            <div class="card">
                <h3>Enable 3FA</h3>
                <p>Enhanced security with mPIN verification.</p>
                <button class="animated-btn" onclick="document.getElementById('mpinModal').style.display='flex'">Enable 3FA</button>
            </div>

            <!-- Modal -->
            <div id="mpinModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeMpinModal()">&times;</span>
                    <h3>Enable 3-Factor Authentication</h3>
                    <form id="mpinForm">
                        <input type="password" id="mpin" placeholder="Enter 4 Digit mPIN" maxlength="4" required style="width:90%;padding:8px;margin-bottom:1em;"><br>
                        <input type="password" id="confirm_mpin" placeholder="Confirm mPIN" maxlength="4" required style="width:90%;padding:8px;margin-bottom:1em;"><br>
                        <button type="submit" class="animated-btn" style="width:100%;">Set mPIN</button>
                    </form>
                </div>
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


        function openMpinModal() {
            document.getElementById('mpinModal').style.display = 'flex';
        }
        function closeMpinModal() {
            document.getElementById('mpinModal').style.display = 'none';
        }

        document.getElementById('mpinForm').onsubmit = function(e) {
            e.preventDefault();
            console.log("Form submitted!");
            const mpin = document.getElementById('mpin').value;
            const confirmMpin = document.getElementById('confirm_mpin').value;

            if (mpin !== confirmMpin) {
                alert("mPINs do not match!");
                return;
            }

            fetch('set_mpin.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `mpin=${mpin}`
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    document.getElementById('mpinModal').style.display = 'none';
                }
            });
        };

    </script>
</body>

</html>