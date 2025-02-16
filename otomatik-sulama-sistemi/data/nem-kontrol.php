<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include_once("../sinif/veri_tabani.php");
    $VT=new veri_tabani();
    // Bağlantıyı kontrol et
    if (!$VT->baglanti) {
        die("Veritabanına bağlanılamadı: " . $VT->baglanti->errorInfo()[2]);
    }


    $nem_kontrol_degeri=$VT->VeriGetir("nem_kontrol","where nem_kontrol_id=?",array(1),"ORDER BY nem_kontrol_id ASC",1);
    if ($nem_kontrol_degeri!=false){
        $nem_kontrol_degeri=$nem_kontrol_degeri[0]["nem_kontrol_degeri"];
    }
    echo $nem_kontrol_degeri;
} else {
    // HTTP isteği POST yöntemiyle gelmemişse hata mesajı gönder
    echo "Geçersiz istek";
}
?>
