<?php
session_start();
require "koneksi.php";

$success = "";
$error = "";

if (isset($_POST['registerbtn'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Cek apakah username sudah digunakan
    $check = mysqli_query($con, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username sudah terdaftar!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // role default 'user'
        $query = mysqli_query($con, "INSERT INTO user (username, password, role) VALUES ('$username', '$hashedPassword', 'user')");

        if ($query) {
            $success = "Registrasi berhasil! Anda akan diarahkan ke halaman login...";
            // Delay 3 detik dan redirect ke login.php
            echo "<meta http-equiv='refresh' content='3;url=login.php'>";
        } else {
            $error = "Registrasi gagal. Coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-image: url(image/bgfilmku.jpg);
            font-family: 'Segoe UI', sans-serif;
        }

        .main {
            height: 100vh;
        }

        .register-box {
            width: 100%;
            max-width: 400px;
            background-color: #D1D8BE;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            border-radius: 8px;
            font-weight: bold;
        }

        .alert {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="main d-flex justify-content-center align-items-center">
        <div class="register-box">
            <h4 class="text-center mb-4">Registrasi Akun</h4>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php elseif ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" name="registerbtn" class="btn btn-primary w-100">Daftar</button>
            </form>
            <div class="text-center mt-3">
                <a href="login.php">Sudah punya akun? Login</a>
            </div>
        </div>
    </div>
</body>

</html>