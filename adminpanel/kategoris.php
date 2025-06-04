<?php
require "session.php";
require "../koneksi.php";;

$querykategoris = mysqli_query($con, "SELECT * FROM kategoris");
$jumlahkategoris = mysqli_num_rows($querykategoris);


if (isset($_POST['simpan_kategoris'])) {
    $kategori = htmlspecialchars($_POST['kategoris']);
    
    
    $cek = mysqli_query($con, "SELECT * FROM kategoris WHERE nama='$kategori'");
    if (mysqli_num_rows($cek) == 0) {
        mysqli_query($con, "INSERT INTO kategoris (nama) VALUES ('$kategori')");
        echo "<script>alert('Kategori berhasil ditambahkan'); window.location.href='kategoris.php';</script>";
    } else {
        echo "<script>alert('Kategori sudah ada!');</script>";
    }
}

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }
</style>

<body class="bg-light">
    <?php require "navbar.php"; ?>
    <div class="container mt-5 p-4 bg-white rounded shadow-sm" style="max-width: 900px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-0 mb-4">
                <li class="breadcrumb-item">
                    <a href="../adminpanel" class="text-decoration-none text-muted">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Kategoris</li>
            </ol>
        </nav>

        <div class="mb-5">
            <h3 class="text-primary fw-bold mb-4">Tambah Kategori</h3>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="kategoris" class="form-label fw-semibold">Kategori</label>
                    <input type="text" id="kategoris" name="kategoris" placeholder="Input nama kategori" class="form-control" required>
                </div>
                <button class="btn btn-primary px-4" type="submit" name="simpan_kategoris">Simpan</button>
            </form>
        </div>

        <div>
            <h2 class="text-primary fw-semibold mb-4">List Kategori</h2>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col" style="width: 60px;">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col" style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahkategoris == 0) {
                        ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted fst-italic">Data Kategoris tidak ada</td>
                            </tr>

                        <?php
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($querykategoris)) {
                        ?>
                                <tr>
                                    <td><?php echo $jumlah; ?></td>
                                    <td><?php echo htmlspecialchars($data['nama']); ?></td>
                                    <td>
                                        <a href="kategoris-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-info btn-sm">
                                            <i class="fa fa-search"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                        <?php
                                $jumlah++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>


</html>