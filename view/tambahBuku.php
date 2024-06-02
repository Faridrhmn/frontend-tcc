<?php 
session_start();

$apiUrlPenerbits = 'https://backend-book-tcc-3klgbesmja-et.a.run.app/penerbits';
$responsePenerbits = file_get_contents($apiUrlPenerbits);
$penerbits = json_decode($responsePenerbits, true);

if (empty($_SESSION['status'])) {
	echo "<script>
            alert('Maaf masuk akun terlebih dahulu!');
            window.location.href='login.php';
          </script>";
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idBuku = isset($_POST['idBuku']) ? $_POST['idBuku'] : null;
    $kategori = isset($_POST['kategori']) ? $_POST['kategori'] : null;
    $namaBuku = isset($_POST['namabuku']) ? $_POST['namabuku'] : null;
    $harga = isset($_POST['harga']) ? $_POST['harga'] : null;
    $stok = isset($_POST['stok']) ? $_POST['stok'] : null;
    $penerbit = isset($_POST['pilihan']) ? $_POST['pilihan'] : null;

    // Periksa apakah semua input telah diisi
    if ($idBuku && $kategori && $namaBuku && $harga && $stok && $penerbit) {
        $url = "https://backend-book-tcc-3klgbesmja-et.a.run.app/books";
        $newBook = [
            'idBuku' => $idBuku,
            'kategori' => $kategori,
            'namaBuku' => $namaBuku,
            'harga' => $harga,
            'stok' => $stok,
            'penerbit' => $penerbit
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $newBook);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200 || $http_code == 201) {
            header('Location: admin.php');
            exit();
        } else {
            echo "Failed to add book. HTTP Status Code: $http_code";
        }
    } else {
        echo "All fields are required.";
    }
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
                    <a class="nav-link" href="?logout">Logout</a>
                </li>
            </ul>
            </div>
        </nav>
        <h3 class="mt-4 mx-5">Tambah Buku</h3>
        <div class="card col-6 mt-4 mx-5">
            <div class="card-header">
                Masukkan data buku
            </div>
            <div class="card-body">
                <form class="row g-3" action="proses/keBuku.php" method="POST">
                    <div class="col-md-4">
                        <label for="inputEmail4" class="form-label">Kode Buku</label>
                        <input type="type" class="form-control" name="idBuku">
                    </div>
                    <div class="col-md-8">
                        <label for="inputPassword4" class="form-label">Kategori</label>
                        <input type="text" class="form-control" name="kategori">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Nama Buku</label>
                        <input type="text" class="form-control" name="namabuku">
                    </div>
                    <div class="col-md-4">
                        <label for="inputCity" class="form-label">Harga</label>
                        <input type="text" class="form-control" name="harga">
                    </div>
                    <div class="col-md-2">
                        <label for="inputZip" class="form-label">Stok</label>
                        <input type="text" class="form-control" name="stok">
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Penerbit</label>
                        <select id="inputState" class="form-select" name="pilihan">
                        <option selected>Pilih</option>
                        <?php 
                            foreach ($penerbits as $penerbit) {
                                echo "<option value=\"{$penerbit['namaPenerbit']}\">{$penerbit['namaPenerbit']}</option>";
                            }
                        ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary float-end">Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>