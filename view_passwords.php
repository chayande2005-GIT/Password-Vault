<?php

session_start();
include("connect.php");

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("Access Denied: User not logged in.");
}

// Check if 3FA is enabled for the user
$stmt = $conn->prepare("SELECT is_mpin_enabled FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($is_mpin_enabled);
$stmt->fetch();
$stmt->close();

$sql = "SELECT * FROM passwords WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Passwords - Password Vault</title>
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
            --table-header: #007bff;
            --table-row-bg: #ffffff;
        }

        [data-theme="dark"] {
            --bg-color: #121212;
            --text-color: #ffffff;
            --accent-color: #1e90ff;
            --card-bg: #1e1e1e;
            --table-header: #1e90ff;
            --table-row-bg: #1a1a1a;
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

        .table-container {
            flex: 1;
            max-width: 1000px;
            margin: 3rem auto;
            padding: 1rem;
        }


        h2 {
            text-align: center;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 1rem;
            text-align: left;
        }

        th {
            background-color: var(--table-header);
            color: white;
        }

        tr:nth-child(even) {
            background-color: var(--table-row-bg);
        }

        .animated-btn {
            background-color: var(--accent-color);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .animated-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        select {
            padding: 0.4rem;
            border-radius: 4px;
        }

        footer {
            background-color: var(--card-bg);
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            margin-top: 3rem;
        }
        .icon-btn {
            background: none;
            border: none;
            font-size: 1.1rem;
            cursor: pointer;
            margin-left: 0.5rem;
            transition: transform 0.2s ease;
        }

        .icon-btn:hover {
            transform: scale(1.2);
        }

        .icon-btn.edit {
            color: #28a745; /* green */
        }

        .icon-btn.delete {
            color: #dc3545; /* red */
        }

    </style>
</head>

<body>
    <header>
        <div class="logo">Password Vault</div>
        <nav>
            <a href="about.php">About</a>
            <a href="home_page.php">Home</a>
            <a href="login.php">Logout</a>
            <button class="btn-login" onclick="window.location.href='save_password.php'">Add Account</button>
            <button class="btn-theme" onclick="toggleTheme()">Change Theme</button>
        </nav>
    </header>

    <div class="table-container">
        <h2>Your Saved Passwords</h2>
        <table>
            <thead>
                <tr>
                    <th>Platform</th>
                    <th>URL/Email</th>
                    <th>User ID</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <?php while ($row = $result->fetch_assoc()): ?>
            <?php
            $platform = $row['site_name'] ?? 'N/A';
            $url = $row['site_url'] ?? 'N/A';
            $user_id = $row['site_username'] ?? 'N/A';
            $password_id = $row['id'];
            ?>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($platform) ?></td>
                    <td><a href="<?= htmlspecialchars($url) ?>" target="_blank"><?= htmlspecialchars($url) ?></a></td>
                    <td><?= htmlspecialchars($user_id) ?></td>
                    <td>******</td>
                     <td>
                        <?php if ($is_mpin_enabled): ?>
                            <button class="animated-btn" onclick="verifyMpinBeforeCopy(<?= $password_id ?>)">Copy</button>
                        <?php else: ?>
                            <button class="animated-btn" onclick="copyPassword(<?= $password_id ?>)">Copy</button>
                        <?php endif; ?>
                        <button class="icon-btn edit" title="Edit" onclick="openEditModal(this.closest('tr'), <?= $password_id ?>)">✏️</button>
                        <button class="icon-btn delete" title="Delete" onclick="confirmAndDelete(this.closest('tr'), <?= $password_id ?>)">🗑️</button>

                    </td>
                </tr>
            </tbody>
            <?php endwhile; ?>
        </table>
    </div>

    <footer>
        &copy; 2025 Password Vault | Secure Your Digital Life | Privacy Policy | Terms of Service
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

        function verifyMpinBeforeCopy(passwordId) {
        const mpin = prompt("Enter your 4-digit mPIN:");
        if (mpin && mpin.length === 4) {
            fetch('verify_mpin.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `mpin=${mpin}&password_id=${passwordId}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    console.log("Decrypted Password:", data.password); // Debugging
                    navigator.clipboard.writeText(data.password)
                        .then(() => alert("Password copied to clipboard."))
                        .catch(err => alert("Failed to copy password: " + err));
                } else {
                    alert(data.message);
                }
            })
            .catch(err => {
                console.error("Error:", err);
                alert("An error occurred while verifying the mPIN.");
            });
        } else {
            alert("Invalid mPIN format.");
        }
    }

    function copyPassword(passwordId) {
        fetch('verify_mpin.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `mpin=&password_id=${passwordId}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                navigator.clipboard.writeText(data.password);
                alert("Password copied to clipboard.");
            } else {
                alert(data.message);
            }
        });
    }

    function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function openEditModal(row, passwordId) {
    const tds = row.querySelectorAll('td');
    document.getElementById('edit_password_id').value = passwordId;
    document.getElementById('edit_site_name').value = tds[0].textContent;
    document.getElementById('edit_site_url').value = tds[1].textContent;
    document.getElementById('edit_site_username').value = tds[2].textContent;
    document.getElementById('edit_site_password').value = ""; // fill manually

    document.getElementById('editModal').style.display = 'block';
}

document.addEventListener('DOMContentLoaded', () => {
    const editForm = document.getElementById('editForm');

    editForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(editForm);
        const mpinEnabled = <?= json_encode($is_mpin_enabled) ?>;

        if (mpinEnabled) {
            const mpin = prompt("Enter your mPIN:");
            if (!mpin || mpin.length !== 4) {
                alert("Invalid mPIN.");
                return;
            }
            formData.append('mpin', mpin);
        } else {
            formData.append('mpin', '');
        }

        fetch('edit_password.php', {
            method: 'POST',
            body: formData  // ✅ FIXED: Use formData directly, not URLSearchParams
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Password updated.");
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            console.error("Edit error:", err);
            alert("An error occurred while updating.");
        });
    });
});


function confirmAndDelete(row, passwordId) {
    let mpin = '';

    <?php if ($is_mpin_enabled): ?>
        mpin = prompt("Enter your mPIN to confirm delete:");
        if (!mpin || mpin.length !== 4) {
            alert("Invalid mPIN.");
            return;
        }
    <?php endif; ?>

    if (confirm("Are you sure you want to delete this password?")) {
        fetch('delete_password.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `password_id=${passwordId}&mpin=${mpin}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Password deleted.");
                location.reload();
            } else {
                alert(data.message);
            }
        });
    }
}


    </script>

    <div id="editModal" style="display:none; position:fixed; top:20%; left:35%; background:#fff; padding:20px; box-shadow:0 0 10px black; border-radius:8px;">
    <h3>Edit Password</h3>
    <form id="editForm">
        <input type="hidden" name="password_id" id="edit_password_id">
        <input type="text" name="site_name" id="edit_site_name" placeholder="Platform" required><br><br>
        <input type="text" name="site_url" id="edit_site_url" placeholder="URL/Email" required><br><br>
        <input type="text" name="site_username" id="edit_site_username" placeholder="User ID" required><br><br>
        <input type="text" name="site_password" id="edit_site_password" placeholder="Password" required><br><br>
        <button type="submit" class="animated-btn">Update</button>
        <button type="button" class="animated-btn" onclick="closeEditModal()">Cancel</button>
    </form>
</div>


</body>

</html>
