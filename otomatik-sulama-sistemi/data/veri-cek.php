<?php
// veri-cek.php
include_once("../sinif/veri_tabani.php");
$VT=new veri_tabani();
// Bağlantıyı kontrol et
if (!$VT->baglanti) {
    die("Veritabanına bağlanılamadı: " . $VT->baglanti->errorInfo()[2]);
}

header('Content-Type: application/json'); // Çıktının JSON formatında olduğunu belirtir

// Toprak nem ölçer verilerini çek
$toprak_nem_olcer=$VT->VeriGetir("toprak_nem_olcer","where nem_olcer_id=?",array(1),"ORDER BY nem_olcer_id ASC", 1);
if ($toprak_nem_olcer!=false) {
    $anlik_nem_degeri = $toprak_nem_olcer[0]["anlik_nem_degeri"];
}

// Ortam verilerini çek
$ortam_degerleri=$VT->VeriGetir("dht11","WHERE dht11_id=?",array(1),"ORDER BY dht11_id ASC", 1);
if ($ortam_degerleri!=false) {
    $ortam_nem_degeri = $ortam_degerleri[0]["ortam_nem_degeri"];
    $ortam_sicaklik_degeri = $ortam_degerleri[0]["ortam_sicaklik_degeri"];
}

// Tüm verileri bir array içinde topla
$response = array(
    'anlikNemDegeri' => $anlik_nem_degeri,
    'ortamNemDegeri' => $ortam_nem_degeri,
    'ortamSicaklikDegeri' => $ortam_sicaklik_degeri,
);

// JSON olarak encode edip döndür
echo json_encode($response);
?>