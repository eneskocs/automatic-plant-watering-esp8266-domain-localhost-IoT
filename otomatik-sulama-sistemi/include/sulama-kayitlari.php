<?php
if($_POST){
    if (isset($_POST['gonder'])){
        if(isset($_POST['id'])){
            foreach ($_POST['id'] as $id){
                $sorgu="DELETE FROM sulama_kayitlari WHERE kayit_sayisi='$id'";
                $calistir=$VT->baglanti->prepare($sorgu);
                $calistir->execute();
            }
        }
    }
}
$kayitlar=$VT->VeriGetir("sulama_kayitlari","where kayit_id=?",array(1),"ORDER BY kayit_sayisi DESC");

// Sayfa numarasını al, varsayılan olarak ilk sayfa
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Sayfa numarasını 1'den küçük olmamak üzere sınırla


// Her sayfada kaç kayıt gösterileceği
$recordsPerPage = 10;

if($kayitlar){
    // Toplam kayıt sayısı
    $totalRecords = count($kayitlar);
    // Toplam sayfa sayısı
    $totalPages = ceil($totalRecords / $recordsPerPage);
}else{
    // Toplam kayıt sayısı
    $totalRecords = 0;
    // Toplam sayfa sayısı
    $totalPages = 1;
}

// Başlangıç kaydı dizinini belirle
$startIndex = ($page - 1) * $recordsPerPage;
// Belirli bir aralıkta sayfalama butonlarını göstermek için gereken değişkenler
$visiblePages = 5; // Gösterilecek sayfa sayısı
$startPage = max(min($page - floor($visiblePages / 2), $totalPages - $visiblePages + 1), 1);
$endPage = min(max($page + floor($visiblePages / 2), $visiblePages), $totalPages);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="padding-top: 20px">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" class="form-control" id="baslangic_tarihi_Sulama" placeholder="Başlangıç Tarihi" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" class="form-control" id="bitis_tarihi_Sulama" placeholder="Bitiş Tarihi" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button id="filter" class="btn btn-outline-info btn-sm">Filter</button>
                                    <button id="reset" class="btn btn-outline-warning btn-sm">Reset</button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <!--<div class="card-header">
                                <h3 class="card-title"><b>Sulama Kayıtları</b></h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="justify-content: end;">
                                        <p><?=$totalRecords?> adet kayıt bulundu.</p>
                                    </div>
                                </div>
                            </div>-->
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap" id="example1">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="hepsiniSecSulama"></th>
                                        <th>ID</th>
                                        <th>Nem</th>
                                        <th>Tarih</th>
                                        <th>Sulama Türü</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php /* if ($kayitlar) {
                                        for ($i = $startIndex; $i < $startIndex+$recordsPerPage; $i++) {?>
                                            <tr>
                                                <?php if(isset($kayitlar[$i]["kayit_sayisi"])){ ?>
                                                <td><input type="checkbox" class="satirSecSulama" value="<?= $kayitlar[$i]["kayit_sayisi"] ?>"
                                                           name="id[]"></td>
                                                <td><?= $kayitlar[$i]["kayit_sayisi"] ?></td>
                                                <td><?= $kayitlar[$i]["nem_degeri"]."%" ?></td>
                                                <td><?= $kayitlar[$i]["sulama_tarihi"] ?></td>
                                                <td><span class="tag tag-success"><?= $kayitlar[$i]["sulama_tipi"] ?></span></td>
                                                <?php }  ?>
                                            </tr>
                                            <?php
                                        }
                                    }else{echo'<td colspan="5" style="text-align: center">Kayit Bulunamadı.</td>';} */ ?>



                                    </tbody>
                                </table>
                               <!-- <hr>
                                <div class="row m-0 mb-0 pb-0">
                                    <div class="col-sm-12 col-md-5">

                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                            <ul class="pagination" style="justify-content: end;">

                                                <li class="paginate_button page-item previous </*?php if($page==1){echo 'disabled';}else{echo '';}?*/>" id="example2_previous"><a href='?sayfa=sulama-kayitlari&page=</*?= $page-1; ?*/>' aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Önceki</a></li>
                                                </*?php
                                                for ($i = $startPage; $i <= $endPage; $i++) {
                                                    echo '<li class="paginate_button page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="?sayfa=sulama-kayitlari&page=' . $i . '">' . $i . '</a></li>';
                                                }

                                                ?*/>
                                                <li class="paginate_button page-item next <*/?php if($page==$totalPages){echo 'disabled';}else{echo '';}?*/>" id="example2_next"><a href='?sayfa=sulama-kayitlari&page=</*?= $page+1; ?*/>' aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">Sonraki</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>  -->

                            </div>
                            <!-- /.card-body -->

                        </div>
                        <!-- /.card -->
                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>



</script>