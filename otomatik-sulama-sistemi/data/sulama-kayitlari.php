<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("../sinif/veri_tabani.php");
    $VT=new veri_tabani();
    // Bağlantıyı kontrol et
    if (!$VT->baglanti) {
        die("Veritabanına bağlanılamadı: " . $VT->baglanti->errorInfo()[2]);
    }

    $sulama_tipi=$_POST["sulama_tipi"];
    $sulama_anlik_nem_degeri=(int)$_POST["anlik_nem_degeri"];
    $tablo = "sulama_kayitlari";
    $sutunlar = array("sulama_tipi", "nem_degeri");
    $veriler = array($sulama_tipi, $sulama_anlik_nem_degeri);

    $kaydet=$VT->VeriKaydet($tablo, $sutunlar, $veriler);
    echo "Sulama kaydı veritabanına eklendi.";

} else {
    // HTTP isteği POST yöntemiyle gelmemişse hata mesajı gönder
    echo "Geçersiz istek";
}
?>