<?php
session_start();
$host = 'localhost'; // Host database
$db = 'db_kampus'; // Nama database
$user = 'root'; // Username database
$pass = ''; // Password database

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek pengguna
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit;
    } else {
        $message = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Global Style */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .login-container {
            display: flex;
            width: 80%;
            max-width: 900px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            background-color: #fff;
        }

        /* Form Section */
        .form-section {
            flex: 1;
            padding: 40px;
        }
        .form-section h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .form-section form {
            display: flex;
            flex-direction: column;
        }
        .form-section label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }
        .form-section input {
            padding: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-section button {
            padding: 10px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-section button:hover {
            background-color: #0056b3;
        }
        .form-section .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        /* Image Section */
        .image-section {
            flex: 1;
            background: url('./icons./download.jpg') no-repeat center center;
            background-size: cover;
            display: none; /* Hidden by default for mobile */
        }

        /* Responsive Style */
        @media (min-width: 768px) {
            .image-section {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Form Login -->
        <div class="form-section">
            <h2>Login</h2>
            <?php if ($message): ?>
                <p class="error"><?php echo $message; ?></p>
            <?php endif; ?>
            <form method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>
        </div>
        <!-- Image Section -->
        <div class="image-section"></div>
    </div>
</body>
</html>
