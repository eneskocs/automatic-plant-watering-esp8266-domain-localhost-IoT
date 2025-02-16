<?php
if($_POST){
    if (isset($_POST['gonder'])){
        if(isset($_POST['id'])){
            foreach ($_POST['id'] as $id){
                $sorgu="DELETE FROM ortam_kayitlari WHERE kayit_sayisi='$id'";
                $calistir=$VT->baglanti->prepare($sorgu);
                $calistir->execute();
            }
        }
    }
}
$kayitlar=$VT->VeriGetir("ortam_kayitlari","where ortam_kayit_id=?",array(1),"ORDER BY kayit_sayisi DESC");

// Sayfa numarasını al, varsayılan olarak ilk sayfa
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Her sayfada kaç kayıt gösterileceği
$recordsPerPage = 10;

// Toplam kayıt sayısı
if($kayitlar){
    // Toplam kayıt sayısı
    $totalRecords = count($kayitlar);
    // Toplam sayfa sayısı
    $totalPages = ceil($totalRecords / $recordsPerPage);
}else{
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
                                        <input type="text" class="form-control" id="baslangic_tarihi_Ortam" placeholder="Başlangıç Tarihi" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" class="form-control" id="bitis_tarihi_Ortam" placeholder="Bitiş Tarihi" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button id="filterOrtam" class="btn btn-outline-info btn-sm">Filter</button>
                                    <button id="resetOrtam" class="btn btn-outline-warning btn-sm">Reset</button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap " id="example2">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="hepsiniSecOrtam"></th>
                                        <th>ID</th>
                                        <th>Ortam Nemi</th>
                                        <th>Ortam Sıcaklığı</th>
                                        <th>Toprak Nemi</th>
                                        <th>Tarih</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>


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
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>