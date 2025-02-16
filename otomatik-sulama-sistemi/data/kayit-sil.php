<?php
    if (isset($_POST['gonder'])){
        if(isset($_POST['id'])){
            include_once("../sinif/veri_tabani.php");
            $VT=new veri_tabani();
            // Bağlantıyı kontrol et
            if (!$VT->baglanti) {
                die("Veritabanına bağlanılamadı: " . $VT->baglanti->errorInfo()[2]);
            }

            foreach ($_POST['id'] as $id){
                $sorgu="DELETE FROM sulama_kayitlari WHERE kayit_sayisi='$id'";
                $calistir=$VT->baglanti->prepare($sorgu);
                $calistir->execute();
            }
        }
    }