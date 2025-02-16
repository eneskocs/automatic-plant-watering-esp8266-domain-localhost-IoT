<?php
class veri_tabani{
    var $sunucu="localhost";
    //var $port="3306";
    var $kullanici_adi="root";
    var $sifre="";
    var $veri_tabani_adi="otomatik-sulama-sistemi";
    var $baglanti;

    function __construct(){
        try {
        $this->baglanti = new PDO("mysql:host=" . $this->sunucu . /*";port=" . $this->port . */";dbname=" . $this->veri_tabani_adi . ";charset=utf8mb4", $this->kullanici_adi, $this->sifre);
        }catch (PDOException $hata){
            echo $hata->getMessage();
            exit();
        }
    }

    /* SELECT * FROM ayarlar, WHERE ID=1 ,ORDER BY ID ASC, LIMIT 1 */
    public function VeriGetir($tablo,$wheresart="",$wheredizideger="",$orderby="ORDER BY ID ASC",$limit="")
    {
        $this->baglanti->query("SET CHARACTER SET utf8mb4");
        $sql="SELECT * FROM" . " " . $tablo;  /* SELECT * FROM ayarlar */
        if(!empty($wheresart) && !empty($wheredizideger)){
            $sql.=" ".$wheresart; /* SELECT * FROM ayarlar WHERE */
            if(!empty($orderby)){$sql.="".$orderby;}
            if(!empty($limit)){$sql.=" LIMIT ".$limit;}
            $calistir=$this->baglanti->prepare($sql);
            $sonuc=$calistir->execute($wheredizideger);
            $veri=$calistir->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            if(!empty($orderby)){$sql.="".$orderby;}
            if(!empty($limit)){$sql.=" LIMIT ".$limit;}
            $veri=$this->baglanti->query($sql,PDO::FETCH_ASSOC);
        }

        if ($veri!=false && !empty($veri))
        {
            $gelenveriler=array();
            foreach ($veri as $bilgiler){
                $gelenveriler[]=$bilgiler;
            }
            return $gelenveriler;
        }
        else{
            return false;
        }
    }

    /* INSERT INTO sulama_kayitlari (sulama_tipi,nem_degeri) VALUES (otomatik,20); */
    public function VeriKaydet($tablo, $sutunlar, $veriler)
    {
        // Karakter setini ayarla
        $this->baglanti->query("SET CHARACTER SET utf8mb4");

        // Sütun ve veri dizilerini kontrol et
        if (count($sutunlar) != count($veriler)) {
            echo "Hata: Sütunlar ve veriler eşleşmiyor.";
            return;
        }

        // Sütunları birleştir
        $sutunStr = implode(", ", $sutunlar);

        // Placeholderları hazırla
        $placeholders = rtrim(str_repeat('?, ', count($veriler)), ', ');

        // SQL sorgusu oluştur
        $sql = "INSERT INTO" . " " . $tablo . " (" . $sutunStr. ") VALUES (" . $placeholders .")";

        try {
            // Sorguyu hazırla ve çalıştır
            $calistir = $this->baglanti->prepare($sql);
            $calistir->execute($veriler);
        } catch (PDOException $e) {
            // Hata durumunda hata mesajını göster
            echo "Hata: " . $e->getMessage();
        }
    }


    /* UPDATE nem_kontrol SET nem_kontrol_degeri=5 WHERE nem_kontrol_id=1; */
    public function VeriGuncelle($tablo,$guncellenenveri,$guncellenendeger,$wheresart="",$wheredizideger="")
    {
        $this->baglanti->query("SET CHARACTER SET utf8mb4");
        $sql="UPDATE" . " " . $tablo . " SET " . $guncellenenveri . "=" . $guncellenendeger . " " . $wheresart;
        $calistir=$this->baglanti->prepare($sql);
        $calistir->execute($wheredizideger);
    }
    public function nem_kontrol(){

        $nem_kontrol_degeri=$_POST["nem_kontrol"];
        $this->VeriGuncelle("nem_kontrol", "nem_kontrol_degeri", $nem_kontrol_degeri, "WHERE nem_kontrol_id=?", array(1));

    }
    public function anlik_nem(){

        $anlik_nem=$_POST["anlik_nem"];
        $this->VeriGuncelle("toprak_nem_olcer", "anlik_nem_degeri", $anlik_nem, "WHERE nem_olcer_id=?", array(1));

    }


    public function date_range($start_date, $end_date)
    {
        $data = [];

        if (isset($start_date) && isset($end_date)) {
            $query = "SELECT * FROM `sulama_kayitlari` WHERE `sulama_tarihi` > '$start_date' AND `sulama_tarihi` < '$end_date' ORDER BY `sulama_tarihi` DESC";
            try {
                // Sorguyu PDO ile çalıştırma
                $stmt = $this->baglanti->prepare($query);
                $stmt->execute();

                // Sonuçları diziye aktarma
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            } catch (PDOException $e) {
                // Hata durumunda hata mesajını yazdır
                echo "Sorgu hatası: " . $e->getMessage();
            }
        }

        return $data;
    }

    public function date_range_ortam($start_date, $end_date)
    {
        $data = [];

        if (isset($start_date) && isset($end_date)) {
            $query = "SELECT * FROM `ortam_kayitlari` WHERE `kayit_tarihi` > '$start_date' AND `kayit_tarihi` < '$end_date' ORDER BY `kayit_tarihi` DESC";
            try {
                // Sorguyu PDO ile çalıştırma
                $stmt = $this->baglanti->prepare($query);
                $stmt->execute();

                // Sonuçları diziye aktarma
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

            } catch (PDOException $e) {
                // Hata durumunda hata mesajını yazdır
                echo "Sorgu hatası: " . $e->getMessage();
            }
        }

        return $data;
    }

    public function filter($val,$tf=false){
        if($tf==false){$val=strip_tags($val);}
        $val=addslashes(trim($val));
        return $val;
    }
}
?>