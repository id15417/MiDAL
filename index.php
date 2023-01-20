<?php

session_start();
include "inc/config.php";
include "fungsi.php";
$msg = '';

if (isset($_POST['login'])) {
    $username   = mysqli_escape_string($koneksi, trim($_POST['username']));
    $password   = mysqli_escape_string($koneksi, sha1($_POST['password']));
    $level      = mysqli_escape_string($koneksi, trim($_POST['level']));

    $sql    = "SELECT * FROM user WHERE username=? AND password=? AND level=?";
    $stmt   = $koneksi->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $level);
    $stmt->execute();
    $result = $stmt->get_result();
    $row    = $result->fetch_assoc();

    session_regenerate_id();
    $_SESSION['akun_id']          = $row['id'];
    $_SESSION['akun_bidang']      = $row['id_bidang'];
    $_SESSION['akun_namaLengkap'] = $row['nama'];
    $_SESSION['akun_username']    = $row['username'];
    $_SESSION['akun_level']       = $row['level'];
    session_write_close();

    if ($result->num_rows == 1 && $_SESSION['akun_level'] == "Administrator") {
        header("location:pages/p463117/index.php");
    } elseif ($result->num_rows == 1 && $_SESSION['akun_level'] == "Pengelola") {
        header("location:pages/page_pengelola/index.php");
    } elseif ($result->num_rows == 1 && $_SESSION['akun_level'] == "Verifikator") {
        header("location:pages/p667/index.php");
    } elseif ($result->num_rows == 1 && $_SESSION['akun_level'] == "Pengguna") {
        header("location:pages/p05312/index.php");
    } else {

        $msg = "<strong>Login gagal!</strong> username dan password tidak cocok!";
        // echo "<script>alert('Login Gagal, Coba lagi!');document.location.href='index.php'</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" sizes="76x76" href="assets/img/logo_midal.png">

    <title>MIDAL | Monitoring Administrasi Pelayanan Internal</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading text-center">
                        <img src="assets/img/logo_midal.png" alt="logo_midal" width="115">
                        <h5 class="panel-header"> Monitoring Administrasi Pelayanan Internal</h5>
                        <b> Balai Besar POM di Manado</b>
                    </div>
                    <div class="panel-body">
                        <h4 class="panel-header text-center">Please Sign In</h4>
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                            <fieldset>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"> <i class="fa fa-user"></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="Username"
                                        autofocus>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        autofocus>
                                </div>
                                <div class="form-group">
                                    <select name="level" class="form-control">
                                        <option value="" selected> Pilih</option>
                                        <option value="Administrator"> Administrator</option>
                                        <option value="Pengelola"> Pengelola</option>
                                        <option value="Verifikator"> Verifikator</option>
                                        <option value="Pengguna"> Pengguna</option>
                                    </select>
                                </div>
                                <div class="form-group" align="center">
                                    <i class="text-danger"><?php echo $msg; ?></i>
                                </div>
                                <div class="checkbox">
                                    <button type="button" class="btn btn-link" data-container="body"
                                        data-toggle="popover" data-placement="top"
                                        data-content="Silahkan hubungi administrator.">
                                        Lupa Password
                                    </button>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" name="login"
                                    class="btn btn-lg btn-primary btn-block">Login</button>
                            </fieldset>
                        </form>

                    </div>
                </div>
                <div class="credits ml-auto" align="center">
                    <span class="copyright">
                        © 2019 -
                        <script>
                        document.write(new Date().getFullYear())
                        </script> Copyright All Reserved by am.doating
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
    <script>
    // tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
    // popover demo
    $("[data-toggle=popover]")
        .popover()
    </script>

</body>

</html>