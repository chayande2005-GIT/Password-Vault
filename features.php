<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Vault - Features</title>
    <style>
        /* General Styling */
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Header */
        header {
            background-color: var(--card-bg);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        header h1 {
            margin: 0;
            color: var(--text-color);
            font-size: 1.8rem;
        }

        /* Navigation Menu */
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav ul li a.active,
        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Features Section */
        .features {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.2);
        }

        .features h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 30px;
            color: var(--accent-color);
        }

        .features ul {
            list-style: none;
            padding: 0;
        }

        .features ul li {
            font-size: 18px;
            margin: 20px 0;
            padding: 15px 20px;
            background-color: var(--item-bg);
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
            transition: transform 0.2s;
        }

        .features ul li:hover {
            transform: translateY(-5px);
        }

        .features ul li span {
            font-weight: bold;
            color: var(--accent-color);
            display: block;
            margin-bottom: 6px;
            font-size: 20px;
        }

        .features ul li p {
            color: var(--text-color);
            font-size: 16px;
            margin: 0;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 15px;
            background-color: var(--card-bg);
            color: var(--text-color);
            margin-top: 50px;
            font-size: 14px;
        }
    </style>    
</head>
<body>
    <header>
        <h1>Password Vault</h1>
        <nav>
            <ul>
                <li><u>Features</u></a></li>
                <li><a href="pricing.php">Pricing</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="features">
        <h2>Why Choose Password Vault?</h2>
        <ul>
            <li>
                <span>🔒 Secure Password Storage</span>
                <p>Your passwords are encrypted using military-grade AES-256 encryption, ensuring complete security and privacy.</p>
            </li>
            <li>
                <span>🛡️ Two-Factor Authentication</span>
                <p>Enable an extra layer of protection with 2FA, requiring both your password and a verification code for login.</p>
            </li>
            <li>
                <span>📁 Encrypted Database</span>
                <p>All stored credentials are encrypted at rest and in transit, ensuring maximum protection against cyber threats.</p>
            </li>
            <li>
                <span>🔍 Advanced Search for Stored Passwords</span>
                <p>Quickly locate your stored passwords using our smart search feature, making password management effortless.</p>
            </li>
            <li>
                <span>☁️ Cloud Backup & Sync</span>
                <p>Seamlessly sync your passwords across multiple devices while keeping your data safely backed up in the cloud.</p>
            </li>
            <li>
                <span>🤖 Auto-Fill & Auto-Generate Strong Passwords</span>
                <p>Generate and auto-fill complex, unique passwords for your accounts, ensuring maximum security with ease.</p>
            </li>
        </ul>
    </section>

    <footer>
        <p>&copy; 2025 Password Vault. All rights reserved.</p>
    </footer>
</body>
</html>
