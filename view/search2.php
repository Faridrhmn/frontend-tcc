<?php 
session_start();

if (empty($_SESSION['status'])) {
    echo "<script>
            alert('Maaf masuk akun terlebih dahulu!');
            window.location.href='login.php';
          </script>";
    exit();
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

if ($cari) {
    $apiUrl = 'https://backend-book-tcc-3klgbesmja-et.a.run.app/books/search?name=' . urlencode($cari);
    $response = file_get_contents($apiUrl);
    $gameData = json_decode($response, true);
} else {
    die("data error");
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
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Admin</a>
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
        <p class="mt-4 mb-0 mx-5">Cari berdasar nama</p>
        <div class="row g-2 align-items-center mx-5">
            <form class="d-flex col-4" role="search" method="get" action="search2.php">
                <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" name="cari" value="<?= htmlspecialchars($cari) ?>">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
        <div class="col-10 mt-4 mx-5">
            <?php
            ?>
            <h5>Pencarian atas nama: <?= htmlspecialchars($cari) ?> </h5>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Buku</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Nama Buku</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Penerbit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (isset($gameData['data']) && !empty($gameData['data'])) {
                        $no = 1;
                        foreach ($gameData['data'] as $data) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$data['IDBuku']}</td>
                                    <td>{$data['Kategori']}</td>
                                    <td>{$data['NamaBuku']}</td>
                                    <td>{$data['Harga']}</td>
                                    <td>{$data['Stok']}</td>
                                    <td>{$data['Penerbit']}</td>
                                  </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7'>No results found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
