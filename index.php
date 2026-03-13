<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Vault</title>
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

        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 4rem 2rem;
            animation: fadeIn 1s ease;
        }

        .hero img {
            max-width: 400px;
            margin-top: 2rem;
        }

        .hero h1 {
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-top: 1rem;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 3rem 2rem;
        }

        .feature-card {
            background-color: var(--card-bg);
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
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

        .btn-get-started {
            padding: 0.5rem 1.5rem;
            margin-left: 1rem;
            border: none;
            border-radius: 25px;
            background: linear-gradient(90deg, var(--accent-color), #00c6ff);
            color: #fff;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,123,255,0.15);
            position: relative;
            overflow: hidden;
            transition: background 0.4s, transform 0.2s;
            z-index: 1;
        }

        .btn-get-started::before {
            content: "";
            position: absolute;
            left: -75%;
            top: 0;
            width: 50%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            transform: skewX(-20deg);
            transition: left 0.5s;
            z-index: 2;
        }

        .btn-get-started:hover {
            background: linear-gradient(90deg, #00c6ff, var(--accent-color));
            transform: scale(1.07);
        }

        .btn-get-started:hover::before {
            left: 120%;
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
            <button class="btn-login" onclick="window.location.href='login.php'">Log In</button>
            <button class="btn-theme" onclick="toggleTheme()">Change Theme</button>
        </nav>
    </header>

    <section class="hero">
        <h1>Secure Your Digital Life</h1>
        <p>Keep all your passwords safe and accessible in one secure place.</p>
        <img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png" alt="Vault Image">
    </section>


    <center><button class="btn-get-started" onclick="window.location.href='registration.php'">Join With Us !</button></center>

    <section class="features">
        <div class="feature-card">
            <h3>Strong Encryption</h3>
            <p>Protect your passwords with top-notch encryption technology.</p>
        </div>
        <div class="feature-card">
            <h3>Multi-Factor Authentication</h3>
            <p>Extra layers of security to keep your vault protected.</p>
        </div>
        <div class="feature-card">
            <h3>Cross-Device Access</h3>
            <p>Access your passwords from any device, anytime.</p>
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
