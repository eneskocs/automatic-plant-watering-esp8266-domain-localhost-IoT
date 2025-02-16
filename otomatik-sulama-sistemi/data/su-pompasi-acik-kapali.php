<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("../sinif/veri_tabani.php");
    $VT=new veri_tabani();
    // Bağlantıyı kontrol et
    if (!$VT->baglanti) {
        die("Veritabanına bağlanılamadı: " . $VT->baglanti->errorInfo()[2]);
    }

    // POST isteğiyle gelen 'durum' parametresini alın
    $durum = $_POST['durum'];
    // Yapılacak işlemleri gerçekleştirin
    if ($durum == 'acik') {
        $guncelle=$VT->VeriGuncelle("su_pompasi", "su_pompasi_devrede_mi", 1, "WHERE su_pompasi_id=?", array(1));
    } else if ($durum == 'kapali') {
        $guncelle=$VT->VeriGuncelle("su_pompasi", "su_pompasi_devrede_mi", 0, "WHERE su_pompasi_id=?", array(1));    }
} else {
    // HTTP isteği POST yöntemiyle gelmemişse hata mesajı gönder
    echo "Geçersiz istek";
}
?>
