<?php
require "session.php";
require "../koneksi.php";

$id = $_GET['p'] ?? '';

$query = mysqli_query($con, "SELECT * FROM kategoris WHERE id = '$id'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Kategori - <?= htmlspecialchars($data['nama']) ?></title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        /* Navbar fixed top */
        body {

            background-image: url(../image/bgfilmku.jpg);
            font-family: 'Poppins', sans-serif;
        }

        nav.navbar {
            box-shadow: 0 4px 8px rgb(0 0 0 / 0.1);
            background-color: rgb(24, 37, 56) !important;

        }

        nav.navbar .navbar-brand,
        nav.navbar .nav-link {
            color: #fff !important;
            font-weight: 600;
        }

        nav.navbar .nav-link:hover {
            color: #cce5ff !important;
        }

        .container {
            max-width: 540px;
        }

        .card {
            border-radius: 15px;
            padding: 2.5rem 2rem;
            box-shadow: 0 12px 24px rgb(0 0 0 / 0.12);
            background: #fff;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgb(0 0 0 / 0.16);
        }

        h2 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #222;
            text-align: center;
        }

        label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.3rem;
            display: block;
        }

        input[type="text"] {
            font-size: 1.15rem;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1.8px solid #ced4da;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="text"]:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.4);
            outline: none;
        }

        .btn {
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 10px 24px;
            width: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }

        .btn-primary:hover {
            background-color: #084cdf;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #b02a37;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 2rem;
        }

        .alert {
            max-width: 540px;
            margin: 0 auto 1.5rem auto;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 6px 18px rgb(0 0 0 / 0.12);
        }
    </style>
</head>

<body>
    <?php require "navbar.php" ?>

    <div class="container">

        <?php
        if (isset($_POST['editBtn'])) {
            $kategoris = htmlspecialchars($_POST['kategoris']);

            if ($data['nama'] == $kategoris) {
                echo '<meta http-equiv="refresh" content="0; url=kategoris.php" />';
            } else {
                $queryCheck = mysqli_query($con, "SELECT * FROM kategoris WHERE nama='$kategoris'");
                $jumlahData = mysqli_num_rows($queryCheck);

                if ($jumlahData > 0) {
                    echo '<div class="alert alert-warning" role="alert">Kategori sudah ada!</div>';
                } else {
                    $querysimpan = mysqli_query($con, "UPDATE kategoris SET nama='$kategoris' WHERE id='$id'");
                    if ($querysimpan) {
                        echo '<div class="alert alert-success" role="alert">Kategori berhasil diupdate.</div>';
                        echo '<meta http-equiv="refresh" content="1; url=kategoris.php" />';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">' . mysqli_error($con) . '</div>';
                    }
                }
            }
        }

        if (isset($_POST['deleteBtn'])) {
            $queryCheck = mysqli_query($con, "SELECT * FROM movies WHERE kategori_id = '$id'");
            $dataCount = mysqli_num_rows($queryCheck);

            if ($dataCount > 0) {
                echo '<div class="alert alert-warning" role="alert">Kategori tidak bisa dihapus karena sedang digunakan di data movies.</div>';
            } else {
                $queryDelete = mysqli_query($con, "DELETE FROM kategoris WHERE id= '$id'");
                if ($queryDelete) {
                    echo '<div class="alert alert-success" role="alert">Kategori berhasil dihapus.</div>';
                    echo '<meta http-equiv="refresh" content="1; url=kategoris.php" />';
                } else {
                    echo '<div class="alert alert-danger" role="alert">' . mysqli_error($con) . '</div>';
                }
            }
        }
        ?>

        <div class="card">
            <h2>Detail Kategori</h2>

            <form action="" method="post" onsubmit="return confirmDelete(event)">
                <label for="kategoris">Nama Kategori</label>
                <input type="text" id="kategoris" name="kategoris" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>

                <div class="btn-group">
                    <button type="submit" name="editBtn" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Update
                    </button>

                    <button type="submit" name="deleteBtn" class="btn btn-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus kategori ini?')">
                        <i class="bi bi-trash3"></i> Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>