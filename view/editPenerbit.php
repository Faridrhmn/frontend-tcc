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
                <a class="nav-link active" href="admin.php">Admin</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="pengadaan.php">Pengadaan</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mx-5">
                <li class="nav-item">
                    <a class="nav-link" href="proses/logout.php">Logout</a>
                </li>
            </ul>
            </div>
        </nav>
        <h3 class="mt-4 mx-5">Edit Penerbit</h3>
        <div class="card col-6 mt-4 mx-5">
            <div class="card-header">
                Masukkan perubahan data penerbit
            </div>
            <?php 
                include 'proses/koneksi.php';
                $idPen = $_GET['idPe'];
                $query = "SELECT * FROM `penerbit` where IDPenerbit =  '$idPen'";

                $sql = mysqli_query($conn, $query);

                while($data = mysqli_fetch_array($sql)){
            ?>
            <div class="card-body">
                <form class="row g-3" action="proses/updatePenerbit.php" method="post">
                    <div class="col-md-4">
                        <label for="inputEmail4" class="form-label">Kode Penerbit</label>
                        <input class="form-control" type="text" value="<?= $data['IDPenerbit'] ?>" placeholder="<?= $data['IDPenerbit'] ?>" aria-label="Disabled input example" name="idP" readonly>
                    </div>
                    <div class="col-md-8">
                        <label for="inputPassword4" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="namaP" value="<?= $data['NamaPenerbit'] ?>">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" value="<?= $data['Alamat'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">Kota</label>
                        <input type="text" class="form-control" name="kota" value="<?= $data['Kota'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="inputZip" class="form-label">Telepon</label>
                        <input type="text" class="form-control" name="telp" value="<?= $data['Telepon'] ?>">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>