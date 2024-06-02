<?php 
session_start();

if (empty($_SESSION['status'])) {
    echo "<script>
            alert('Maaf, silakan masuk terlebih dahulu!');
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
    $idPenerbit = isset($_POST['idP']) ? $_POST['idP'] : null;
    $namaPenerbit = isset($_POST['namaP']) ? $_POST['namaP'] : null;
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;
    $kota = isset($_POST['kota']) ? $_POST['kota'] : null;
    $telepon = isset($_POST['telp']) ? $_POST['telp'] : null;

    // Periksa apakah semua input telah diisi
    if ($idPenerbit && $namaPenerbit && $alamat && $kota && $telepon) {
        $url = "https://backend-book-tcc-3klgbesmja-et.a.run.app/penerbits/$idPenerbit";
        $newPenerbit = json_encode([
            'idPenerbit' => $idPenerbit,
            'namaPenerbit' => $namaPenerbit,
            'alamat' => $alamat,
            'kota' => $kota,
            'telepon' => $telepon
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $newPenerbit);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200 || $http_code == 201) {
            header('Location: admin.php');
            exit();
        } else {
            echo "Failed to update penerbit. HTTP Status Code: $http_code";
        }
    } else {
        echo "All fields are required.";
    }
} else {
    $idPenerbit = isset($_GET['idPe']) ? $_GET['idPe'] : null;

    if ($idPenerbit) {
        $apiUrl = "https://backend-book-tcc-3klgbesmja-et.a.run.app/penerbits/$idPenerbit";
        $response = file_get_contents($apiUrl);
        $penerbitData = json_decode($response, true);

        if (!$penerbitData) {
            die("Failed to fetch penerbit data.");
        }
    } else {
        die("Failed to retrieve penerbit ID.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penerbit</title>
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
        <h3 class="mt-4 mx-5">Edit Penerbit</h3>
        <div class="card col-6 mt-4 mx-5">
            <div class="card-header">
                Masukkan perubahan data penerbit
            </div>
            <div class="card-body">
                <form class="row g-3" action="" method="post">
                    <div class="col-md-4">
                        <label for="idP" class="form-label">Kode Penerbit</label>
                        <input class="form-control" type="text" value="<?= $penerbitData['idPenerbit'] ?>" placeholder="<?= $penerbitData['idPenerbit'] ?>" aria-label="Disabled input example" name="idP" readonly>
                    </div>
                    <div class="col-md-8">
                        <label for="namaP" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="namaP" value="<?= $penerbitData['namaPenerbit'] ?>">
                    </div>
                    <div class="col-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" value="<?= $penerbitData['alamat'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="kota" class="form-label">Kota</label>
                        <input type="text" class="form-control" name="kota" value="<?= $penerbitData['kota'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="telp" class="form-label">Telepon</label>
                        <input type="text" class="form-control" name="telp" value="<?= $penerbitData['telepon'] ?>">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
