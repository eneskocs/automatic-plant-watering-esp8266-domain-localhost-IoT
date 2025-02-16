<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
    .slow .toggle-group { transition: left 0.7s; -webkit-transition: left 0.7s; }
    .fast .toggle-group { transition: left 0.1s; -webkit-transition: left 0.1s; }
    .quick .toggle-group { transition: none; -webkit-transition: none; }
</style>
<?php

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Kontrol Paneli</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i style="font-size: 45px;" class="fa fa-hand-holding-water"></i></span>

                        <div class="info-box-content d-flex" style="flex-wrap: wrap; flex-direction: row;">
                            <div class="col-md-8" style=" display: table;"><span class="info-box-text" style="display: table-cell; vertical-align: middle; text-align: center; font-size: xx-large;font-weight: 600;">Toprak Nemi :</span></div>
                            <div class="col-md-4" style="display: table;"><span class="info-box-number anlik-veri-font" style="display: table-cell; vertical-align: middle; text-align: center; font-size: xx-large;" id="toprakNemiDegeri">Yükleniyor...</span></div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><img style="max-width: 80%;"  src="dist/img/ortam-nemi.png"></span>


                        <div class="info-box-content d-flex" style="flex-wrap: wrap; flex-direction: row;">
                            <div class="col-md-8" style=" display: table;"><span class="info-box-text" style="display: table-cell; vertical-align: middle; text-align: center; font-size: xx-large;font-weight: 600;">Ortam Nemi :</span></div>
                            <div class="col-md-4" style="display: table;"><span class="info-box-number anlik-veri-font" style="display: table-cell; vertical-align: middle; text-align: center; font-size: xx-large;" id="ortamNemiDegeri">Yükleniyor...</span></div>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i style="font-size: 45px;" class="fa fa-temperature-low"></i></span>
                        <div class="info-box-content d-flex" style="flex-wrap: wrap; flex-direction: row;">
                            <div class="col-md-8" style=" display: table;"><span class="info-box-text" style="display: table-cell; vertical-align: middle; text-align: center; font-size: xx-large; font-weight: 600;">Sıcaklık :</span></div>
                            <div class="col-md-4" style="display: table;"><span class="info-box-number anlik-veri-font" style="display: table-cell; vertical-align: middle; text-align: center; font-size: xx-large;" id="ortamSicaklikDegeri">Yükleniyor...</span></div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <!-- /.col -->
                <div class="col-md-3 col-sm-3 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><img style="max-width: 80%;"  src="dist/img/nem-kontrol.png"></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Nem Kontrol</span>
                            <form role="form" id="form" action="<?php $_SERVER['PHP_SELF']?>" method="post">
                            <span class="info-box-number">nem < <input
                                        type="number"
                                        min="0"
                                        max="100"
                                        class="form-control"
                                        value="<?=$nem_kontrol_degeri?>"
                                        name="nem_kontrol"
                                        style="width: 20%; height: 15px; padding: 0px; text-align: center; display: inline-block;" >%</span>
                           <!--     <button type="submit" class="btn btn-app" id="gonder" style="margin: 0; width: min-content; padding: 0; height: min-content; margin-left: auto;">
                                    <i class="fas fa-save" style="display: inline-block;"></i> Kayıt
                                </button>-->
                            </form>
                            <a class="btn btn-app" id="gonder" type="submit" style="margin: 0; width: min-content; padding: 0; height: min-content; margin-left: auto;">
                                <i class="fas fa-save" style="display: inline-block;"></i> Kayıt
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-3 col-12">
                    <div class="info-box">
                        <span class="info-box-icon " style="background-color: blueviolet;"><img style="max-width: 80%;"  src="dist/img/ortam-nemi.png"></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ortam Nem Kontrol</span>
                            <form role="form" id="form2" action="<?php $_SERVER['PHP_SELF']?>" method="post">
                            <span class="info-box-number">nem < <input
                                        type="number"
                                        min="0"
                                        max="100"
                                        class="form-control"
                                        value="<?=$ortam_nem_kontrol_degeri?>"
                                        name="ortam_nem_kontrol"
                                        style="width: 20%; height: 15px; padding: 0px; text-align: center; display: inline-block;" >%</span>
                                <!--     <button type="submit" class="btn btn-app" id="gonder" style="margin: 0; width: min-content; padding: 0; height: min-content; margin-left: auto;">
                                         <i class="fas fa-save" style="display: inline-block;"></i> Kayıt
                                     </button>-->
                            </form>
                            <a class="btn btn-app" id="gonder2" type="submit" style="margin: 0; width: min-content; padding: 0; height: min-content; margin-left: auto;">
                                <i class="fas fa-save" style="display: inline-block;"></i> Kayıt
                            </a>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-3 col-6">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span style="margin-bottom: 6px; text-align: end;" class="info-box-text">Otomatik Sulama</span>
                            <div style="width: 86px; margin-left: auto;">
                                <input id="otomatik-sulama"  class="su-pompasi" data-height="30" type="checkbox" data-on="Açık" data-off="Kapalı" <?php echo $checked_otomatik_sulama; ?> data-toggle="toggle" data-style="slow" data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class=" col-md-3 col-sm-3 col-6">
                    <div class="info-box">
                        <div class="info-box-content">
                            <span style="margin-bottom: 6px; text-align: end;" class="info-box-text">Su Pompası</span>
                            <div style="width: 86px; margin-left: auto;">
                                <input id="su-pompasi"  class="su-pompasi" data-height="30" type="checkbox" data-on="Açık" data-off="Kapalı" <?php echo $checked_su_pompasi; ?> data-toggle="toggle" data-style="slow" data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Son Sulama Kayıtları</h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px; justify-content: end;">
                                     <!--   <input type="text" name="table_search" class="form-control float-right" placeholder="Arama">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div> -->
                                        <input type="submit" name="sulama-kayit-sil" value="Sil" onclick="return
                                            confirm('Silmek istediğinden emin misin?')" class="btn btn-danger">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                  <!--  <tr>
                                        <td>
                                            <input type="submit" name="gonder" value="Sil" onclick="return
                                            confirm('Silmek istediğinden emin misin?')" class="btn btn-danger">
                                        </td>
                                    </tr>-->

                                    <tr>
                                        <th><input type="checkbox" id="hepsiniSecSulama"></th>
                                        <th>ID</th>
                                        <th>Nem</th>
                                        <th>Tarih</th>
                                        <th>Sulama Türü</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    <?php if ($sulama_kayitlar!=false) {
                                        for ($i = 0; $i < 10; $i++) {?>
                                    <tr>
                                        <td><input type="checkbox" class="satirSecSulama" value="<?= $sulama_kayitlar[$i]["kayit_sayisi"] ?>"
                                            name="id[]"></td>
                                        <td><?= $sulama_kayitlar[$i]["kayit_sayisi"] ?></td>
                                        <td><?= $sulama_kayitlar[$i]["nem_degeri"]."%" ?></td>
                                        <td><?= $sulama_kayitlar[$i]["sulama_tarihi"] ?></td>
                                        <td><span class="tag tag-success"><?= $sulama_kayitlar[$i]["sulama_tipi"] ?></span></td>
                                    </tr>
                                    <?php
                                        }
                                    } ?>



                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </form>
                </div>
                <div class="col-12 col-md-6">
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Son Ortam Kayıtları</h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px; justify-content: end;">
                                        <!--   <input type="text" name="table_search" class="form-control float-right" placeholder="Arama">

                                           <div class="input-group-append">
                                               <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                           </div> -->
                                        <input type="submit" name="ortam-kayit-sil" value="Sil" onclick="return
                                            confirm('Silmek istediğinden emin misin?')" class="btn btn-danger">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <!--  <tr>
                                          <td>
                                              <input type="submit" name="gonder" value="Sil" onclick="return
                                              confirm('Silmek istediğinden emin misin?')" class="btn btn-danger">
                                          </td>
                                      </tr>-->

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
                                    <?php if ($ortam_kayitlar!=false) {
                                        for ($i = 0; $i < 10; $i++) {?>
                                            <tr>
                                                <?php if(isset($ortam_kayitlar[$i]["kayit_sayisi"])){ ?>
                                                <td><input type="checkbox" class="satirSecOrtam" value="<?= $ortam_kayitlar[$i]["kayit_sayisi"] ?>"
                                                           name="id[]"></td>
                                                <td><?= $ortam_kayitlar[$i]["kayit_sayisi"] ?></td>
                                                <td><?= $ortam_kayitlar[$i]["ortam_nemi"]."%" ?></td>
                                                <td><?= $ortam_kayitlar[$i]["ortam_sicakligi"]."°C" ?></td>
                                                <td><?= $ortam_kayitlar[$i]["toprak_nemi"]."%" ?></td>
                                                <td><span class="tag tag-success"><?= $ortam_kayitlar[$i]["kayit_tarihi"] ?></span></td>
                                                <?php }  ?>

                                            </tr>
                                            <?php
                                        }
                                    }else{echo'<td colspan="6" style="text-align: center">Kayit Bulunamadı.</td>';} ?>



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
    document.getElementById("gonder").onclick = function() {
        document.getElementById("form").submit();
    }
    document.getElementById("gonder2").onclick = function() {
        document.getElementById("form2").submit();
    }

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function verileriGuncelle() {
        $.ajax({
            url: 'data/veri-cek.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // 'toprakNemiDegeri' ID'li span elementini güncelle
                $('#toprakNemiDegeri').text(data.anlikNemDegeri + '%');
                $('#ortamNemiDegeri').text(data.ortamNemDegeri + '%');
                $('#ortamSicaklikDegeri').text(data.ortamSicaklikDegeri + '°C');
            },
            error: function() {
                $('#toprakNemiDegeri').text('Veri alınamadı');
                $('#ortamNemiDegeri').text('Veri alınamadı');
                $('#ortamSicaklikDegeri').text('Veri alınamadı');
            }
        });
    }

    // Sayfa yüklendiğinde ve belirli aralıklarla veriyi güncelle
    $(document).ready(function() {
        verileriGuncelle();
        setInterval(verileriGuncelle, 1000); // Her 2 saniyede bir verileri güncelle
    });
</script>