<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Password Vault</title>
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

        /* About Section */
        .about {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.2);
        }

        .about h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 30px;
            color: var(--accent-color);
        }

        .about p {
            font-size: 18px;
            color: var(--text-color);
            line-height: 1.6;
        }

        /* Content Boxes */
        .content-box {
            margin-top: 30px;
            padding: 20px;
            background-color: var(--item-bg);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
            transition: transform 0.3s;
        }

        .content-box:hover {
            transform: translateY(-5px);
        }

        .content-box h3 {
            color: var(--accent-color);
            font-size: 22px;
            margin-bottom: 10px;
        }

        .content-box p {
            font-size: 16px;
            color: var(--text-color);
        }

        .content-box ul {
            list-style: none;
            padding: 0;
        }

        .content-box ul li {
            font-size: 16px;
            margin: 10px 0;
            color: var(--text-color);
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
                <li><a href="index.php">Home</a></li>
                <li><a href="features.php">Features</a></li>
                <li><a href="pricing.php">Pricing</a></li>
                <li><u>About</u></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="about">
        <h2>About Password Vault</h2>
        <p>Welcome to Password Vault, the ultimate solution for managing and securing your passwords effortlessly. With the rise of cyber threats, having a <b>safe and encrypted</b> place to store your credentials is more important than ever.</p>
    
        <h3>🔒 Why Choose Password Vault?</h3>
        <p>Password Vault is built with <b>military-grade encryption</b>, ensuring that your credentials remain safe from hackers and cybercriminals. Our platform is designed for both individuals and businesses, providing an <b>easy-to-use interface</b> without compromising security.</p>
        
        <div class="content-box">
            <h3>⚙️ How It Works</h3>
            <p>Using Password Vault is simple:</p>
            <ul>
                <li>➡️ **Create an account** and set up a master password.</li>
                <li>➡️ **Store your credentials** securely using our encrypted database.</li>
                <li>➡️ **Auto-fill passwords** in your favorite websites and apps.</li>
                <li>➡️ **Access anytime, anywhere** with cloud sync enabled.</li>
            </ul>
        </div>

        <div class="content-box">
            <h3>🛠️ Technologies Used</h3>
            <p>Password Vault is powered by the latest **security-driven technologies**:</p>
            <ul>
                <li>✔️ <b>AES-256 encryption</b> for password protection.</li>
                <li>✔️ <b>Django & MySQL</b> for backend and secure database management.</li>
                <li>✔️ <b>Two-Factor Authentication (2FA)</b> for added security.</li>
                <li>✔️ <b>Cross-platform compatibility</b> (Windows, Linux, Android).</li>
            </ul>
        </div>

        <div class="content-box">
            <h3>🛡️ Security & Privacy</h3>
            <p>We take security <b>very seriously</b>. Your passwords are encrypted before they leave your device, meaning <b>not even we can see them</b>. With 2FA, <b>biometric login</b>, and <b>zero-knowledge architecture<b>, your data stays protected at all times.</p>
        </div>

        <div class="content-box">
            <h3>🌍 Accessibility & Features</h3>
            <p>Our <b>user-friendly dashboard</b> makes it easy to <b>organize, categorize, and retrieve<b> stored credentials instantly. Plus, <b>seamless browser extensions</b> allow auto-login without manual password input.</p>
        </div>

        <div class="content-box">
            <h3>🚀 Future Enhancements</h3>
            <p>We are constantly working on **improving Password Vault**. Here are some upcoming features:</p>
            <ul>
                <li>🔜 **AI-powered password strength suggestions**</li>
                <li>🔜 **Dark web monitoring for credential leaks**</li>
                <li>🔜 **Offline mode for better security**</li>
            </ul>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Password Vault. All rights reserved.</p>
    </footer>
</body>
</html>