<?php
include_once(SINIF."veri_tabani.php");
$VT=new veri_tabani();
$ayarlar=$VT->VeriGetir("ayarlar","where ID=?",array(1),"ORDER BY ID ASC", 1);

if ($ayarlar!=false){
    $sitebaslik=$ayarlar[0]["baslik"];
    $siteanahtar=$ayarlar[0]["anahtar"];
    $siteaciklama=$ayarlar[0]["aciklama"];
    $siteURL=$ayarlar[0]["url"];
}

?>