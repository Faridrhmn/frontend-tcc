<?php
session_start();
$apiUrl = 'https://backend-book-tcc-3klgbesmja-et.a.run.app/books';

// Check if user is logged in
if (empty($_SESSION['status'])) {
    echo "<script>
            alert('Maaf masuk akun terlebih dahulu!');
            window.location.href='login.php';
          </script>";
    exit;
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    session_unset();
    header("Location: login.php");
    exit;
}

$response = file_get_contents($apiUrl);
if ($response === FALSE) {
    die("Error: Unable to fetch data from the API.");
}

$booksResponse = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error: Invalid JSON response from the API.");
}

$books = isset($booksResponse['data']) ? $booksResponse['data'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
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
        </div>
    </nav>

    <!-- Search form -->
    <p class="mt-4 mb-0 mx-5">Cari berdasar nama</p>
    <div class="row g-2 align-items-center mx-5">
        <form class="d-flex col-4" role="search" method="get" action="search2.php">
            <input class="form-control me-3" type="search" placeholder="Search" aria-label="Search" name="cari">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>

    <div class="col-10 mt-4 mx-5">
            <h5>List data buku</h5>
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
                    if (is_array($books)) {
                        $no = 1;
                        foreach ($books as $book) {
                ?>
                    <tr>
                    <td><?=$no?></th>
                    <td><?=htmlspecialchars($book['IDBuku'])?></td>
                    <td><?=htmlspecialchars($book['Kategori'])?></td>
                    <td><?=htmlspecialchars($book['NamaBuku'])?></td>
                    <td><?=htmlspecialchars($book['Harga'])?></td>
                    <td><?=htmlspecialchars($book['Stok'])?></td>
                    <td><?=htmlspecialchars($book['Penerbit'])?></td>
                    </tr>
                <?php 
                    $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7'>No data available.</td></tr>";
                    } 
                ?>
                </tbody>
            </table>
        </div>
</body>
</html>
