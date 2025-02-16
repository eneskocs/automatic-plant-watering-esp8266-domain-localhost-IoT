<?php
@session_start();
@ob_start();
define("DATA","data/");
define("SAYFA","include/");
define("SINIF","sinif/");
include_once(DATA."baglanti.php");
define("SITE","$siteURL");
if (!empty($_SESSION["id"]) && !empty($_SESSION["kullanici"]) && !empty($_SESSION["mail"]))
{}
else
{
    ?>
    <meta http-equiv="refresh" content="0;url=<?=SITE?>giris"/> <!--Giriş yapılmadıysa giriş sayfasına yönlendir-->
    <?php
    exit();
}

$toprak_nem_olcer=$VT->VeriGetir("toprak_nem_olcer","where nem_olcer_id=?",array(1),"ORDER BY nem_olcer_id ASC", 1); //Toprak nem ölçer değerini veritabanından getir
if ($toprak_nem_olcer!=false) {
    $anlik_nem_degeri = $toprak_nem_olcer[0]["anlik_nem_degeri"];
}
$ortam_degerleri=$VT->VeriGetir("dht11","WHERE dht11_id=?",array(1),"ORDER BY dht11_id ASC", 1);//Ortam değerlerini veritabanından getir
if ($ortam_degerleri!=false) {
    $ortam_nem_degeri = $ortam_degerleri[0]["ortam_nem_degeri"];
    $ortam_sicaklik_degeri = $ortam_degerleri[0]["ortam_sicaklik_degeri"];
}
if($_POST){
    if(isset($_POST['nem_kontrol'])){
        $calistir=$VT->nem_kontrol();
    }
    if(isset($_POST['ortam_nem_kontrol'])){
        $ortam_nem_kontrol_degeri=$_POST["ortam_nem_kontrol"];
        $calistir=$VT->VeriGuncelle("nem_kontrol", "ortam_nem_kontrol_degeri", $ortam_nem_kontrol_degeri, "WHERE nem_kontrol_id=?", array(1));
    }
    if (isset($_POST['sulama-kayit-sil'])){
        if(isset($_POST['id'])){
            foreach ($_POST['id'] as $id){
                $sorgu="DELETE FROM sulama_kayitlari WHERE kayit_sayisi='$id'";
                $calistir=$VT->baglanti->prepare($sorgu);
                $calistir->execute();
            }
        }
    }
    if (isset($_POST['ortam-kayit-sil'])){
        if(isset($_POST['id'])){
            foreach ($_POST['id'] as $id){
                $sorgu="DELETE FROM ortam_kayitlari WHERE kayit_sayisi='$id'";
                $calistir=$VT->baglanti->prepare($sorgu);
                $calistir->execute();
            }
        }
    }
}
$nem_kontrol_degeri=$VT->VeriGetir("nem_kontrol","where nem_kontrol_id=?",array(1),"ORDER BY nem_kontrol_id ASC",1);
$sulama_kayitlar=$VT->VeriGetir("sulama_kayitlari","where kayit_id=?",array(1),"ORDER BY kayit_sayisi DESC", 10);
$ortam_kayitlar=$VT->VeriGetir("ortam_kayitlari","where ortam_kayit_id=?",array(1),"ORDER BY kayit_sayisi DESC", 10);
if ($nem_kontrol_degeri!=false){
    $ortam_nem_kontrol_degeri=$nem_kontrol_degeri[0]["ortam_nem_kontrol_degeri"];
    $nem_kontrol_degeri=$nem_kontrol_degeri[0]["nem_kontrol_degeri"];
}
$checked_su_pompasi=$VT->VeriGetir("su_pompasi","where su_pompasi_id=?",array(1),"ORDER BY su_pompasi_id ASC",1);
if ($checked_su_pompasi!=false){
    $checked_su_pompasi=$checked_su_pompasi[0]["su_pompasi_devrede_mi"];
}
if ($checked_su_pompasi == 1) {
    $checked_su_pompasi = 'checked';
} else {
    $checked_su_pompasi = ' ';
}
$checked_otomatik_sulama=$VT->VeriGetir("otomatik_sulama_sistemi","where id=?",array(1),"ORDER BY id ASC",1);
if ($checked_otomatik_sulama!=false){
    $checked_otomatik_sulama=$checked_otomatik_sulama[0]["sistem_devrede_mi"];
}
if ($checked_otomatik_sulama == 1) {
    $checked_otomatik_sulama = 'checked';
} else {
    $checked_otomatik_sulama = ' ';
}

$sorgu="SELECT COUNT(*) AS kayitBildirimSayisi FROM sulama_kayitlari WHERE sulama_tarihi >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
$kayitBildirim=$VT->baglanti->prepare($sorgu);
$kayitBildirim->execute();
// Sonuçları almak için fetch() veya fetchAll() yöntemini kullanmalısınız
$kayitBildirimSonucu = $kayitBildirim->fetch(PDO::FETCH_ASSOC);
$kayitBildirimSayisiSulama = $kayitBildirimSonucu["kayitBildirimSayisi"];

$sorgu="SELECT COUNT(*) AS kayitBildirimSayisi FROM ortam_kayitlari WHERE kayit_tarihi >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
$kayitBildirim=$VT->baglanti->prepare($sorgu);
$kayitBildirim->execute();
// Sonuçları almak için fetch() veya fetchAll() yöntemini kullanmalısınız
$kayitBildirimSonucu = $kayitBildirim->fetch(PDO::FETCH_ASSOC);
$kayitBildirimSayisiOrtam = $kayitBildirimSonucu["kayitBildirimSayisi"];
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <!-- Font Awesome -->
    <link rel="apple-touch-icon" sizes="180x180" href="dist/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="dist/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="dist/img/favicon-16x16.png">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Bootstrap Toogle -->
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <!-- DATATABLE -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <!--DatePicker-->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
  <!--datatablesMin-->
  <link href="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.0.7/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" rel="stylesheet">

    <style>
        .form-control ,.hasDatepicker{
            cursor: pointer;
        }
        .anlik-veri-font{
            font-size: larger;
            color: crimson;
            -webkit-text-stroke-width: 0.4px;
            -webkit-text-stroke-color: black;
        }
        #logo{
            width: 100%;
            height: auto;
        }
        #example1 td,#example1 th,#example2 td,#example2 th{
            text-align: center !important;
        }
        #example1, #example2{
            width: 100% !important;
        }
        table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order:before{
            display: none !important;
        }
        .sulama-tablo-ust,.ortam-tablo-ust{
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, .125);
            padding: .75rem 1.25rem;
            position: relative;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
        }
        .sulama-tablo-baslik,.ortam-tablo-baslik{
            margin: auto;
        }
        div.dt-container div.dt-info{
            text-align: end;
            padding-top: 0 ;
        }
        .custom-table-head{
            padding: .75rem 1.25rem;
        }
        .custom-table-btn{
            text-align: center;
        }
        .custom-table-search{
            text-align: end;
        }
        .custom-table-alt{
            width: 100% !important;
            padding: .75rem 1.25rem;
        }
        .custom-table-pagination .pagination{
            float: right;
        }
        div.dt-container div.dt-info{
            white-space: pre-wrap;
        }
        .info-box .info-box-content{
            width: 100%;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


<?php

include_once(DATA."ust.php");
include_once(DATA."menu.php");
if($_GET && ! empty($_GET["sayfa"])){
    $sayfa=$_GET["sayfa"].".php";
    if (file_exists(SAYFA.$sayfa)){
        include_once(SAYFA.$sayfa);
    }
    else{
        include_once(SAYFA."anasayfa.php");
    }
}
else {
    include_once(SAYFA . "anasayfa.php");
}

include_once(DATA ."alt.php");
?>









  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Bootstrap Toogle -->
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- DATATABLE -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!--DATEPİCKER -->
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.0.7/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script>
    $(document).ready(function() {
        $('#su-pompasi').on('change', function() {
            var checked = this.checked;
            var url;
            var durum;

            if (checked) {
                url = 'data/su-pompasi-acik-kapali.php';
                durum = 'acik';
            } else {
                url = 'data/su-pompasi-acik-kapali.php';
                durum = 'kapali';
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    console.log('İstek başarılı');
                } else {
                    console.error('İstek başarısız: ' + xhr.status);
                }
            };
            xhr.send('durum=' + durum);
        });
    });

    $(document).ready(function() {
        $('#otomatik-sulama').on('change', function() {
            var checked = this.checked;
            var url;
            var durum;

            if (checked) {
                url = 'data/otomatik-sulama-acik-kapali.php';
                durum = 'acik';
            } else {
                url = 'data/otomatik-sulama-acik-kapali.php';
                durum = 'kapali';
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    console.log('İstek başarılı');
                } else {
                    console.error('İstek başarısız: ' + xhr.status);
                }
            };
            xhr.send('durum=' + durum);
        });
    });
    $(document).ready(function (){

        $("#hepsiniSecSulama").click(function (){
            if($(this).is(":checked")){
                $(".satirSecSulama").prop('checked',true);
            }
            else{
                $(".satirSecSulama").prop('checked',false);
            }
        });
        $("#hepsiniSecOrtam").click(function (){
            if($(this).is(":checked")){
                $(".satirSecOrtam").prop('checked',true);
            }
            else{
                $(".satirSecOrtam").prop('checked',false);
            }
        });
    });

    //DatePicker
    $( function() {
        $( "#baslangic_tarihi_Sulama" ).datepicker({
            "dateFormat": "dd-mm-yy"
        });
        $( "#bitis_tarihi_Sulama" ).datepicker({
            "dateFormat": "dd-mm-yy"
        });

    } );


    //DataTable Sulama Kayitlari
    function fetchSulama(baslangic_tarihi_Sulama, bitis_tarihi_Sulama) {
        $.ajax({
            url: "data/records.php",
            type: "POST",
            data: {
                baslangic_tarihi_Sulama: baslangic_tarihi_Sulama,
                bitis_tarihi_Sulama: bitis_tarihi_Sulama
            },
            dataType: "json",
            success: function(data) {
                //Datatables
                var i = "1";
                var table = new DataTable('#example1',{
                    "language": {
                        "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                        "sInfo":           "Toplam _TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                        "sInfoEmpty":      "Kayıt yok",
                        "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                        "sInfoPostFix":    "",
                        "sInfoThousands":  ",",
                        "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                        "sLoadingRecords": "Yükleniyor...",
                        "sProcessing":     "İşleniyor...",
                        "sSearch":         "Ara:",
                        "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                        "oPaginate": {
                            "sFirst":    "İlk",
                            "sLast":     "Son",
                            "sNext":     "Sonraki",
                            "sPrevious": "Önceki"
                        },
                        "oAria": {
                            "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                            "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                        },
                        "buttons": {
                            "copy": "Kopyala",
                            "colvis": "Sütun görünürlüğü",
                            "print": "Yazdır"
                        }
                    },
                    columnDefs: [
                        { type: 'date', targets: 3, } // 0. sütun için tarih sıralama
                    ],
                    layout: {
                        topStart: {
                            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                        }
                    },
                    "dom":"<'row sulama-tablo-ust'<'sulama-tablo-baslik col-sm-12 col-md-6'><'col-sm-12 col-md-6'i>>"+
                        "<'row custom-table-head'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 custom-table-btn'B><'col-sm-12 col-md-4 custom-table-search'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row custom-table-alt'<'col-md-2 sulama-kayit-sil'><'col-sm-12 col-md-10 custom-table-pagination'p>>",
                    "data" : data,
                    "responsive": true,
                    columns: [
                        { data: 'kayit_sayisi',"width":"2%",orderable: false,
                            render: function(data, type, row) {
                                return '<input type="checkbox" class="satirSecSulama" value="' + data + '" name="id[]">';
                            }
                        },
                        { data: 'kayit_sayisi'},
                        { data: 'nem_degeri',
                            render: function(data, type, row) {
                                return  data + '%';
                            }
                        },
                        { data: 'sulama_tarihi',
                            render: function (data, type, row) {
                                if (type === 'sort') {
                                    // Sıralama yapılırken tarihleri 'YYYY-MM-DD' formatına dönüştür
                                    return moment(data).format('YYYY-MM-DD');
                                }
                                    return moment(data).format('DD-MM-YYYY HH:mm:ss');

                            }
                        },
                        { data: 'sulama_tipi' }
                    ],
                });
                // Her sayfa değiştiğinde checkbox'ları sıfırla
                table.on('draw', function() {
                    $('#hepsiniSecSulama, .satirSecSulama').prop('checked', false);
                });
                $("div.sulama-kayit-sil").html('<input type="submit" name="gonder" value="Sil"  class="btn btn-danger">');
                $("div.sulama-kayit-sil").find("input[type=submit]").attr("onclick", "return confirm('Silmek istediğinden emin misin?')");
                $("div.sulama-tablo-baslik").html('<h3 class="card-title"><b>Sulama Kayıtları</b></h3>');
            }
        });
    }
    fetchSulama();

    // Filter

    $(document).on("click", "#filter", function(e) {
        e.preventDefault();

        var baslangic_tarihi_Sulama = $("#baslangic_tarihi_Sulama").val();
        console.log(baslangic_tarihi_Sulama);
        var bitis_tarihi_Sulama = $("#bitis_tarihi_Sulama").val();
        console.log(bitis_tarihi_Sulama);



        if (baslangic_tarihi_Sulama == "" || bitis_tarihi_Sulama == "") {
            alert("Lütfen tarihleri eksiksiz giriniz");
        } else {
            // Baslangic tarihini formatla (yy-mm-dd)
            var baslangic_tarih_parts = baslangic_tarihi_Sulama.split('-');
            var formatted_baslangic_tarih = baslangic_tarih_parts[2] + '-' + baslangic_tarih_parts[1] + '-' + baslangic_tarih_parts[0];
            console.log(formatted_baslangic_tarih);

            // Bitis tarihini formatla (yy-mm-dd)
            var bitis_tarih_parts = bitis_tarihi_Sulama.split('-');
            var formatted_bitis_tarih = bitis_tarih_parts[2] + '-' + bitis_tarih_parts[1] + '-' + bitis_tarih_parts[0];
            console.log(formatted_bitis_tarih);
            $('#example1').DataTable().destroy();
            fetchSulama(formatted_baslangic_tarih, formatted_bitis_tarih);
        }
    });

    // Reset

    $(document).on("click", "#reset", function(e) {
        e.preventDefault();

        $("#baslangic_tarihi_Sulama").val(''); // empty value
        $("#bitis_tarihi_Sulama").val('');

        $('#example1').DataTable().destroy();
        fetchSulama();
    });

    // ortam kayıtları datatable
    //DatePicker
    $( function() {
        $( "#baslangic_tarihi_Ortam" ).datepicker({
            "dateFormat": "dd-mm-yy"
        });
        $( "#bitis_tarihi_Ortam" ).datepicker({
            "dateFormat": "dd-mm-yy"
        });

    } );


    //DataTable Ortam Kayitlari
    function fetchOrtam(baslangic_tarihi_Ortam, bitis_tarihi_Ortam) {
        $.ajax({
            url: "data/DataTablesOrtam.php",
            type: "POST",
            data: {
                baslangic_tarihi_Ortam: baslangic_tarihi_Ortam,
                bitis_tarihi_Ortam: bitis_tarihi_Ortam
            },
            dataType: "json",
            success: function(data) {
                //Datatables
                var i = "1";
                var table = new DataTable('#example2',{
                    "language": {
                        "sEmptyTable":     "Tabloda herhangi bir veri mevcut değil",
                        "sInfo":           "Toplam _TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                        "sInfoEmpty":      "Kayıt yok",
                        "sInfoFiltered":   "(_MAX_ kayıt içerisinden bulunan)",
                        "sInfoPostFix":    "",
                        "sInfoThousands":  ",",
                        "sLengthMenu":     "Sayfada _MENU_ kayıt göster",
                        "sLoadingRecords": "Yükleniyor...",
                        "sProcessing":     "İşleniyor...",
                        "sSearch":         "Ara:",
                        "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                        "oPaginate": {
                            "sFirst":    "İlk",
                            "sLast":     "Son",
                            "sNext":     "Sonraki",
                            "sPrevious": "Önceki"
                        },
                        "oAria": {
                            "sSortAscending":  ": artan sütun sıralamasını aktifleştir",
                            "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
                        },
                        "buttons": {
                            "copy": "Kopyala",
                            "colvis": "Sütun görünürlüğü",
                            "print": "Yazdır"
                        }
                    },
                    columnDefs: [
                        { type: 'date', targets: 5 } // 0. sütun için tarih sıralama
                    ],
                    layout: {
                        topStart: {
                            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                        }
                    },
                    "dom":"<'row ortam-tablo-ust'<'ortam-tablo-baslik col-sm-12 col-md-6'><'col-sm-12 col-md-6'i>>"+
                        "<'row custom-table-head'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 custom-table-btn'B><'col-sm-12 col-md-4 custom-table-search'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row custom-table-alt'<'col-md-2 ortam-kayit-sil'><'col-sm-12 col-md-10 custom-table-pagination'p>>",
                    "data" : data,
                    "responsive": true,
                    columns: [
                        { data: 'kayit_sayisi',"width":"2%",orderable: false,
                            render: function(data, type, row) {
                                return '<input type="checkbox" class="satirSecOrtam" value="' + data + '" name="id[]">';
                            }
                        },
                        { data: 'kayit_sayisi'},
                        { data: 'ortam_nemi',
                            render: function(data, type, row) {
                                return  data + '%';
                            }
                        },
                        { data: 'ortam_sicakligi',
                            render: function(data, type, row) {
                                return  data + '°C';
                            }
                        },
                        { data: 'toprak_nemi',
                            render: function(data, type, row) {
                                return  data + '%';
                            }
                        },
                        { data: 'kayit_tarihi',
                            render: function (data, type, row) {
                                if (type === 'sort') {
                                    // Sıralama yapılırken tarihleri 'YYYY-MM-DD' formatına dönüştür
                                    return moment(data).format('YYYY-MM-DD');
                                }
                                return moment(data).format('DD-MM-YYYY HH:mm:ss');

                            }
                        }
                    ],
                });
                // Her sayfa değiştiğinde checkbox'ları sıfırla
                table.on('draw', function() {
                    $('#hepsiniSecOrtam, .satirSecOrtam').prop('checked', false);
                });
                $("div.ortam-kayit-sil").html('<input type="submit" name="gonder" value="Sil"  class="btn btn-danger">');
                $("div.ortam-kayit-sil").find("input[type=submit]").attr("onclick", "return confirm('Silmek istediğinden emin misin?')");
                $("div.ortam-tablo-baslik").html('<h3 class="card-title"><b>Ortam Kayıtları</b></h3>');
            }
        });
    }
    fetchOrtam();

    // Filter

    $(document).on("click", "#filterOrtam", function(e) {
        e.preventDefault();

        var baslangic_tarihi_Ortam = $("#baslangic_tarihi_Ortam").val();
        console.log(baslangic_tarihi_Ortam);
        var bitis_tarihi_Ortam = $("#bitis_tarihi_Ortam").val();
        console.log(bitis_tarihi_Ortam);


        if (baslangic_tarihi_Ortam == "" || bitis_tarihi_Ortam == "") {
            alert("Lütfen tarihleri eksiksiz giriniz");
        } else {
            // Baslangic tarihini formatla (yy-mm-dd)
            var baslangic_tarih_parts = baslangic_tarihi_Ortam.split('-');
            var formatted_baslangic_tarih = baslangic_tarih_parts[2] + '-' + baslangic_tarih_parts[1] + '-' + baslangic_tarih_parts[0];
            console.log(formatted_baslangic_tarih);

            // Bitis tarihini formatla (yy-mm-dd)
            var bitis_tarih_parts = bitis_tarihi_Ortam.split('-');
            var formatted_bitis_tarih = bitis_tarih_parts[2] + '-' + bitis_tarih_parts[1] + '-' + bitis_tarih_parts[0];
            console.log(formatted_bitis_tarih);
            $('#example2').DataTable().destroy();
            fetchOrtam(formatted_baslangic_tarih, formatted_bitis_tarih);
        }
    });

    // Reset

    $(document).on("click", "#resetOrtam", function(e) {
        e.preventDefault();

        $("#baslangic_tarihi_Ortam").val(''); // empty value
        $("#bitis_tarihi_Ortam").val('');

        $('#example2').DataTable().destroy();
        fetchOrtam();
    });


</script>

</body>
</html>
