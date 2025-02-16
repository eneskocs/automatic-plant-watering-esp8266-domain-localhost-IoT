<?php

include '../sinif/veri_tabani.php';

$VT=new veri_tabani();
// Bağlantıyı kontrol et
if (!$VT->baglanti) {
    die("Veritabanına bağlanılamadı: " . $VT->baglanti->errorInfo()[2]);
}


if (isset($_POST['baslangic_tarihi_Sulama']) && isset($_POST['bitis_tarihi_Sulama'])) {
    $start_date = $_POST['baslangic_tarihi_Sulama'];
    $end_date = $_POST['bitis_tarihi_Sulama'];

    $kayitlar = $VT->date_range($start_date, $end_date);
} else {
    $kayitlar=$VT->VeriGetir("sulama_kayitlari","where kayit_id=?",array(1),"ORDER BY kayit_sayisi DESC");
}

echo json_encode($kayitlar);