<?php
@session_start();
@ob_start();
define("DATA","data/");
define("SAYFA","include/");
define("SINIF","sinif/");
include_once(DATA."baglanti.php");
define("SITE","$siteURL");
if (!empty($_SESSION["id"]) && !empty($_SESSION["kullanici"]) && !empty($_SESSION["mail"]))
{
    ?>
    <meta http-equiv="refresh" content="0;url=<?=SITE?>"/>
    <?php
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$sitebaslik?></title>
    <meta http-equiv="keywords" content="<?=$siteanahtar?>">
    <meta http-equiv="description" content="<?=$siteaciklama?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="dist/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="dist/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="dist/img/favicon-16x16.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=SITE?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=SITE?>https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=SITE?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=SITE?>dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?=SITE?>"><b>Yönetim </b>Girişi</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Giriş yapmak için bilgilerinizi yazınız.</p>
        <?php
        if ($_POST)
        {
            if (!empty($_POST["kullanici"]) && !empty($_POST["sifre"]))
            {
                $kullanici=$VT->filter($_POST["kullanici"]);
                $sifre=md5($VT->filter($_POST["sifre"]));
                $kontrol=$VT->VeriGetir("yonetici","WHERE kullanici_adi=? AND sifre=?",array($kullanici,$sifre),"ORDER BY yonetici_id ASC",1);
                if ($kontrol!=false){
                    echo '<div class="alert alert-success">Giriş başarılı</div>';
                    $_SESSION["kullanici"]=$kontrol[0]["kullanici_adi"];
                    $_SESSION["mail"]=$kontrol[0]["email"];
                    $_SESSION["id"]=$kontrol[0]["yonetici_id"];
                    ?>
                    <meta http-equiv="refresh" content="0;url=<?=SITE?>"/>
                    <?php
                    exit();
                }
                else{
                    echo '<div class="alert alert-danger">Kullanıcı adı veya şifre hatalı</div>';
                }
            }
            else
            {
                echo '<div class="alert alert-danger">Boş bıraktığınız alanları doldurunuz</div>' ;
            }
        }
        ?>

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="kullanici" placeholder="Kullanıcı Adı">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="sifre" placeholder="Şifre">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">

          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Giriş Yap</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?=SITE?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=SITE?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=SITE?>dist/js/adminlte.min.js"></script>

</body>
</html>
