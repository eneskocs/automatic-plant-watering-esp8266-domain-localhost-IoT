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
    $toprak_nemi=(int)$_POST["toprak_nemi"];
    $tablo = "ortam_kayitlari";
    $sutunlar = array("ortam_nemi", "ortam_sicakligi", "toprak_nemi");
    $veriler = array($ortam_nemi, $ortam_sicakligi, $toprak_nemi);

    $kaydet=$VT->VeriKaydet($tablo, $sutunlar, $veriler);
    echo "ORTAM KAYITLARI eklendi ";

} else {
    // HTTP isteği POST yöntemiyle gelmemişse hata mesajı gönder
    echo "Geçersiz istek";
}
?>