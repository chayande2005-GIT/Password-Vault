<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Password Vault</title>
    <style>
        /* General Styling */
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            transition: background-color 0.4s ease, color 0.4s ease;
        }

        /* Header */
        header {
            background-color: var(--card-bg);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        header h1 {
            margin: 0;
            color: var(--text-color);
            font-size: 1.5rem;
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
            transition: color 0.3s ease;
        }

        nav ul li a.active,
        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Contact Section */
        .contact {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.2);
            transition: background-color 0.4s ease;
        }

        .contact h2 {
            color: var(--accent-color);
            text-align: center;
            font-size: 30px;
        }

        .contact p {
            font-size: 18px;
            color: var(--text-color);
            text-align: center;
            line-height: 1.6;
        }

        /* Contact Boxes */
        .contact-box {
            margin-top: 30px;
            padding: 20px;
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 8px;
            transition: border 0.3s ease;
        }

        .contact-box h3 {
            color: var(--accent-color);
            font-size: 22px;
        }

        .contact-box p {
            font-size: 16px;
            color: var(--text-color);
            margin: 10px 0;
        }

        .contact-box a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: bold;
        }

        .contact-box a:hover {
            text-decoration: underline;
        }

        /* Contact Form */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: var(--text-color);
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--input-border);
            border-radius: 6px;
            background-color: var(--input-bg);
            color: var(--text-color);
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input:focus, textarea:focus {
            border-color: var(--accent-color);
            outline: none;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        button {
            background-color: var(--accent-color);
            color: white;
            font-size: 18px;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.03);
        }

        /* Social Links */
        .social-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .social-links li {
            margin: 10px 0;
        }

        .social-links li a {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }

        .social-links li a:hover {
            text-decoration: underline;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 15px;
            background-color: var(--card-bg);
            color: var(--text-color);
            margin-top: 50px;
            transition: background-color 0.3s ease;
        }
    </style>  
</head>
<body>
    <header>
        <h1>Password Vault</h1>
        <nav>
            <ul>
                <li><a href="features.php">Features</a></li>
                <li><a href="pricing.php">Pricing</a></li>
                <li><a href="about.php">About</a></li>
                <li><u>Contact</u></li>
            </ul>
        </nav>
    </header>

    <section class="contact">
        <h2>Contact Us</h2>
        <p>If you have any questions, feedback, or need support, feel free to reach out to us. Our team is here to help you!</p>

        <div class="contact-box">
            <h3>📧 Get in Touch</h3>
            <form>
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="message">Your Message:</label>
                <textarea id="message" name="message" rows="5" placeholder="Type your message here..." required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>

        <div class="contact-box">
            <h3>📍 Our Location</h3>
            <p>123 Cyber Street, Secure City, SC 45678</p>
            <p>📞 Phone: +91 98765 43210</p>
            <p>📧 Email: support@passwordvault.com</p>
        </div>

        <div class="contact-box">
            <h3>🔗 Connect with Us</h3>
            <ul class="social-links">
                <li><a href="#">🌐 Official Website</a></li>
                <li><a href="#">📘 Facebook</a></li>
                <li><a href="#">🐦 Twitter</a></li>
                <li><a href="#">📷 Instagram</a></li>
                <li><a href="#">📺 YouTube</a></li>
            </ul>
        </div>

        <div class="contact-box">
            <h3>🛠️ Customer Support</h3>
            <p>If you need **technical support**, visit our <a href="#">Help Center</a> or email us at <strong>help@passwordvault.com</strong>.</p>
            <p>For urgent queries, contact our **24/7 support hotline** at <strong>+91 99999 88888</strong>.</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Password Vault. All rights reserved.</p>
    </footer>
</body>
</html>
