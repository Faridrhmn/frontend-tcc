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
        <div class="row mt-4 mx-5">
            <div class="col">
                <div class="col-10">
                    <table class="table col-9">
                        <thead>
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Buku</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                include 'proses/koneksi.php';
                                $query = "SELECT * FROM `buku`";

                                $sql = mysqli_query($conn, $query);
                                $no = 1;

                                while($data = mysqli_fetch_array($sql)){
                            ?>
                            <tr>
                            <td><?=$no?></td>
                            <td><?=$data['NamaBuku']?>
                            <a href="proses/hapusBuku.php?idB=<?= $data['IDBuku'] ?>" class="badge text-bg-danger p-2 rounded-pill float-end" style="text-decoration: none;">Hapus</a>
                            <a href="editBuku.php?idBu=<?= $data['IDBuku'] ?>" class="badge text-bg-warning p-2 mx-2 rounded-pill float-end" style="text-decoration: none;">Edit</a>
                            </td>
                            </tr>
                            <?php $no+=1; } ?>
                        </tbody>
                    </table>
                    <a href="tambahBuku.php" class="btn btn-primary float-end">Tambah Buku</a>
                </div>
            </div>
            <div class="col">
            <div class="col-10">
                    <table class="table col-9">
                        <thead>
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Penerbit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                include 'proses/koneksi.php';
                                $query = "SELECT * FROM `penerbit`";

                                $sql = mysqli_query($conn, $query);
                                $no = 1;

                                while($data = mysqli_fetch_array($sql)){
                            ?>
                            <tr>
                            <td><?=$no?></td>
                            <td><?=$data['NamaPenerbit']?>
                            <a href="proses/hapusPenerbit.php?idP=<?= $data['IDPenerbit'] ?>" class="badge text-bg-danger p-2 rounded-pill float-end" style="text-decoration: none;">Hapus</a>
                            <a href="editPenerbit.php?idPe=<?= $data['IDPenerbit'] ?>" class="badge text-bg-warning p-2 mx-2 rounded-pill float-end" style="text-decoration: none;">Edit</a>
                            </td>
                            </tr>
                            <?php $no+=1; } ?>
                        </tbody>
                    </table>
                    <a href="tambahPenerbit.php" class="btn btn-primary float-end">Tambah Penerbit</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>