<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include_once("../sinif/veri_tabani.php");
    $VT=new veri_tabani();
    // Bağlantıyı kontrol et
    if (!$VT->baglanti) {
        die("Veritabanına bağlanılamadı: " . $VT->baglanti->errorInfo()[2]);
    }


    $sistem_devrede_mi=$VT->VeriGetir("otomatik_sulama_sistemi","where id=?",array(1),"ORDER BY id ASC",1);
    if ($sistem_devrede_mi!=false){
        $sistem_devrede_mi=$sistem_devrede_mi[0]["sistem_devrede_mi"];
    }
    echo $sistem_devrede_mi;
} else {
    // HTTP isteği POST yöntemiyle gelmemişse hata mesajı gönder
    echo "Geçersiz istek";
}
?>