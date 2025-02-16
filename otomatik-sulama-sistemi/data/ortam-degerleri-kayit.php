<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("../sinif/veri_tabani.php");
    $VT=new veri_tabani();
    // Bağlantıyı kontrol et
    if (!$VT->baglanti) {
        die("Veritabanına bağlanılamadı: " . $VT->baglanti->errorInfo()[2]);
    }


    $ortam_nemi=(int)$_POST["ortam_nemi"];
    $ortam_sicakligi=(int)$_POST["ortam_sicakligi"];
    $VT->VeriGuncelle("dht11","ortam_nem_degeri",$ortam_nemi,"WHERE dht11_id=?",array(1));
    $VT->VeriGuncelle("dht11","ortam_sicaklik_degeri",$ortam_sicakligi,"WHERE dht11_id=?",array(1));
    echo "Ortam değerleri veritabanına eklendi.";

} else {
    // HTTP isteği POST yöntemiyle gelmemişse hata mesajı gönder
    echo "Geçersiz istek";
}
?>