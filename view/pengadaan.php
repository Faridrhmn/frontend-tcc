<?php 
session_start();

if (empty($_SESSION['status'])) {
	echo "<script>
            alert('Maaf masuk akun terlebih dahulu!');
            window.location.href='login.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-5">
                <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="admin.php">Admin</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" href="pengadaan.php">Pengadaan</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mx-5">
                <li class="nav-item">
                    <a class="nav-link" href="proses/logout.php">Logout</a>
                </li>
            </ul>
            </div>
        </nav>
        <?php 
                include 'proses/koneksi.php';
                $query = "SELECT * FROM `buku` ORDER BY Stok LIMIT 1";

                $sql = mysqli_query($conn, $query);

                $data = mysqli_fetch_array($sql);
        ?>
        <div class="card mt-4 mx-5" style="width: 30rem;">
            <div class="card-body">
                <h5 class="card-title"><?= $data['NamaBuku'] ?> / <?= $data['Penerbit'] ?></h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">Sisa stok : <?= $data['Stok'] ?></h6>
                <p class="card-text">Dibutuhkan segera buku tersebut karena stok menipis dan kebutuhan meningkat.</p>
            </div>
        </div>
    </div>
</body>
</html>