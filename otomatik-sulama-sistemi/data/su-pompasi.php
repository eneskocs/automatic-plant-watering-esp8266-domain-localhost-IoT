<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include_once("../sinif/veri_tabani.php");
    $VT=new veri_tabani();
    // Bağlantıyı kontrol et
    if (!$VT->baglanti) {
        die("Veritabanına bağlanılamadı: " . $VT->baglanti->errorInfo()[2]);
    }


    $su_pompasi=$VT->VeriGetir("su_pompasi","where su_pompasi_id=?",array(1),"ORDER BY su_pompasi_id ASC",1);
    if ($su_pompasi!=false){
        $su_pompasi=$su_pompasi[0]["su_pompasi_devrede_mi"];
    }
    echo $su_pompasi;
} else {
    // HTTP isteği POST yöntemiyle gelmemişse hata mesajı gönder
    echo "Geçersiz istek";
}
?>