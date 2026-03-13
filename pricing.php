<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Vault - Pricing</title>
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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

        /* Pricing Section */
        .pricing {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.2);
            text-align: center;
        }

        .pricing h2 {
            color: var(--accent-color);
            font-size: 32px;
            margin-bottom: 15px;
        }

        .pricing p {
            font-size: 18px;
            color: var(--text-color);
            line-height: 1.6;
        }

        /* Pricing Table */
        .pricing-table {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 30px;
            gap: 20px;
        }

        .plan {
            background-color: var(--plan-bg);
            padding: 25px;
            border-radius: 12px;
            width: 30%;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .plan:hover {
            transform: translateY(-5px);
        }

        .plan h3 {
            color: var(--accent-color);
            font-size: 24px;
            margin-bottom: 10px;
        }

        .plan .price {
            font-size: 26px;
            font-weight: bold;
            color: var(--text-color);
            margin-bottom: 15px;
        }

        .plan ul {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
        }

        .plan ul li {
            font-size: 16px;
            margin: 10px 0;
            color: var(--text-color);
        }

        .plan button {
            background-color: var(--accent-color);
            color: #fff;
            font-size: 16px;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .plan button:hover {
            background-color: #0056b3;
        }

        /* Highlight popular plan */
        .popular {
            border: 2px solid var(--accent-color);
            transform: scale(1.05);
        }

        /* FAQ Section */
        .faq {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.2);
        }

        .faq h2 {
            color: var(--accent-color);
            text-align: center;
            font-size: 30px;
            margin-bottom: 20px;
        }

        .question {
            margin-top: 20px;
            padding: 20px;
            background-color: var(--plan-bg);
            border-radius: 8px;
        }

        .question h3 {
            color: var(--accent-color);
            font-size: 20px;
            margin-bottom: 10px;
        }

        .question p {
            font-size: 16px;
            color: var(--text-color);
            line-height: 1.5;
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
                <li><a href="features.php">Features</a></li>
                <li><u>Pricing</u></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="pricing">
        <h2>Choose the Perfect Plan for You</h2>
        <p>Our pricing is designed to be affordable while ensuring top-notch security for your credentials.</p>

        <div class="pricing-table">
            <div class="plan">
                <h3>Free Plan</h3>
                <p class="price">₹0 / month</p>
                <ul>
                    <li>✔️ Store up to 20 passwords</li>
                    <li>✔️ Basic encryption</li>
                    <li>❌ No cloud sync</li>
                    <li>❌ No two-factor authentication</li>
                </ul>
                <button>Select Plan</button>
            </div>

            <div class="plan popular">
                <h3>Premium Plan</h3>
                <p class="price">₹199 / month</p>
                <ul>
                    <li>✔️ Unlimited password storage</li>
                    <li>✔️ Advanced AES-256 encryption</li>
                    <li>✔️ Cloud sync across devices</li>
                    <li>✔️ Two-factor authentication</li>
                    <li>✔️ Secure password sharing</li>
                </ul>
                <button>Select Plan</button>
            </div>

            <div class="plan">
                <h3>Enterprise Plan</h3>
                <p class="price">₹499 / month</p>
                <ul>
                    <li>✔️ Everything in Premium</li>
                    <li>✔️ Team password management</li>
                    <li>✔️ Priority customer support</li>
                    <li>✔️ Security audit reports</li>
                </ul>
                <button>Select Plan</button>
            </div>
        </div>
    </section>

    <section class="faq">
        <h2>Frequently Asked Questions</h2>
        <div class="question">
            <h3>Is the Free Plan really free?</h3>
            <p>Yes! The Free Plan lets you store up to 20 passwords at no cost.</p>
        </div>
        <div class="question">
            <h3>Can I upgrade or cancel my plan anytime?</h3>
            <p>Absolutely! You can upgrade, downgrade, or cancel your plan at any time from your account settings.</p>
        </div>
        <div class="question">
            <h3>What payment methods do you accept?</h3>
            <p>We accept credit/debit cards, UPI, and net banking.</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Password Vault. All rights reserved.</p>
    </footer>
</body>
</html>
