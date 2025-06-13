<?php
session_start();
require "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
</head>

<style>
    body {
        background-image: url(image/bgfilmku.jpg);
        background-size: cover;
        background-position: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

.login-box {
    background-color: rgba(255, 255, 255, 0.2); /* Putih dengan 20% opacity */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Bayangan untuk kontras */
    backdrop-filter: blur(10px); /* Blur latar belakang di belakang box */
    -webkit-backdrop-filter: blur(10px); /* Untuk dukungan Safari */
}


    .login-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .btn-success {
        border-radius: 10px;
        font-weight: 700;
        font-size: 1.1rem;
        padding: 10px 0;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #A7C1A8;
    }

    .alert {
        border-radius: 10px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .text-center p {
        font-weight: 500;
        color: #555;
    }

    .btn-outline-primary {
        font-weight: 600;
        border-radius: 10px;
        padding: 8px 0;
        font-size: 1rem;
    }
</style>

<body>
    <div class="login-box shadow">
        <h4 class="text-center mb-4 fw-bold text-warning-emphasis">Login Filmku</h4>
        <form action="" method="post" novalidate>
            <div class="mb-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control form-control-lg" name="username" id="username" required autofocus />
            </div>
            <div class="mb-4 text-light">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control form-control-lg" name="password" id="password" required />
            </div>
            <button class="btn btn-success w-100" type="submit" name="loginbtn">Login</button>
            <div class="text-center mt-4">
                <p class="mb-2">Belum punya akun?</p>
                <a href="regis.php" class="btn btn-outline-primary w-100">Daftar Akun</a>
            </div>
        </form>

        <div class="mt-3">
            <?php
            if (isset($_POST['loginbtn'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                $query = mysqli_query($con, "SELECT * FROM user WHERE username= '$username'");
                $countdata = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);

                if ($countdata > 0) {
                    if (password_verify($password, $data['password'])) {
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['role'] = $data['role'];
                        $_SESSION['login'] = true;

                        if ($data['role'] === 'admin') {
                            header('Location: adminpanel/index.php');
                        } else {
                            header('Location: index.php');
                        }
                        exit;
                    } else {
                        echo '<div class="alert alert-warning mt-2" role="alert">Password salah</div>';
                    }
                } else {
                    echo '<div class="alert alert-warning mt-2" role="alert">Akun tidak tersedia</div>';
                }
            }
            ?>
        </div>
    </div>
</body>

</html>
