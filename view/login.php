<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Both username and password are required.'); window.location.href = 'login.php';</script>";
        exit();
    }

    $url = 'https://backend-auth-tcc-3klgbesmja-et.a.run.app/login';
    $data = array(
        'username' => $username,
        'password' => $password
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === false) {
        echo "<script>alert('Error: Failed!'); window.location.href = 'login.php';</script>";
    } else {
        $response = json_decode($result, true);
        if ($response['status'] === 'success') {
            $_SESSION['status'] = "login";
            header('Location: index.php');
            exit();
        } else {
            $status = $response['status'];
            $errorMessage = $response['error']['message'];
            echo "<script>alert('Login failed: $status - $errorMessage'); window.location.href = 'login.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</head>
<body>
<section class="vh-100 gradient-custom bg-body-tertiary">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card text-white" style="border-radius: 1rem; background-color:  rgb(73, 71, 68);">
          <div class="card-body p-5 text-center">
            <div class="mb-md-3 mt-md-4 pb-5">
              <h2 class="fw-bold mb-2 text-uppercase">Masuk</h2>
              <p class="text-white-80 mb-5">Masukkan username dan password anda</p>

              <form method="post" action="">
                  <div data-mdb-input-init class="form-outline form-white mb-4">
                    <input type="text" id="username" class="form-control form-control-lg" name="username" required />
                    <label class="form-label" for="username">Username</label>
                  </div>
    
                  <div data-mdb-input-init class="form-outline form-white mb-4">
                    <input type="password" id="typePasswordX" class="form-control form-control-lg" name="password" required />
                    <label class="form-label" for="typePasswordX">Password</label>
                  </div>
    
                  <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit">Masuk</button>
              </form>
            </div>

            <div>
              <p class="mb-0">Tidak punya akun? <a href="register.php" class="text-white-50 fw-bold">Daftar</a>
              </p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>