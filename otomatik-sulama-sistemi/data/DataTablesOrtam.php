<?php

include '../sinif/veri_tabani.php';

$VT=new veri_tabani();
// Bağlantıyı kontrol et
if (!$VT->baglanti) {
    die("Veritabanına bağlanılamadı: " . $VT->baglanti->errorInfo()[2]);
}

if (isset($_POST['baslangic_tarihi_Ortam']) && isset($_POST['bitis_tarihi_Ortam'])) {
    $start_date = $_POST['baslangic_tarihi_Ortam'];
    $end_date = $_POST['bitis_tarihi_Ortam'];

    $kayitlar = $VT->date_range_ortam($start_date, $end_date);
} else {
    $kayitlar=$VT->VeriGetir("ortam_kayitlari","where ortam_kayit_id=?",array(1),"ORDER BY kayit_sayisi DESC");
}

echo json_encode($kayitlar);