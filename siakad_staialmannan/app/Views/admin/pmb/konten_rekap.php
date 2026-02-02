<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">Rekapitulasi Calon Mahasiswa Baru</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header border-0">
            <h3 class="card-title">Rekap Mahasiswa Baru</h3>
          </div>
          <div class="card-body table-responsive p-0">
            <table id="dt-global" class="table table-striped table-valign-middle table-sm">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Jenjang</th>
                  <th class="text-center">Terverikasi</th>
                  <th class="text-center">Belum Terverikasi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center">1.</td>
                  <td class="text-center">S1</td>
                  <td class="text-center"><?=(!empty(getCount('db_pmb', ['Tahun_Masuk' => $ta, 'program_sekolah' => 'S1', 'status_valid' => '1'], "Tahun_Masuk", "program_sekolah")))?getCount('db_pmb', ['Tahun_Masuk' => $ta, 'program_sekolah' => 'S1', 'status_valid' => '1'], "Tahun_Masuk", "program_sekolah")['program_sekolah']:0?></td>
                  <td class="text-center"><?=(!empty(getCount('db_pmb', ['Tahun_Masuk' => $ta, 'program_sekolah' => 'S1', 'status_valid' => '0'], "Tahun_Masuk", "program_sekolah")))?getCount('db_pmb', ['Tahun_Masuk' => $ta, 'program_sekolah' => 'S1', 'status_valid' => '0'], "Tahun_Masuk", "program_sekolah")['program_sekolah']:0?></td>  
                </tr>
                <tr>
                  <td class="text-center">2.</td>
                  <td class="text-center">S2</td>

                  <td class="text-center"><?=(!empty(getCount('db_pmb', ['Tahun_Masuk' => $ta, 'program_sekolah' => 'S2', 'status_valid' => '1'], "Tahun_Masuk", "program_sekolah")))?getCount('db_pmb', ['Tahun_Masuk' => $ta, 'program_sekolah' => 'S2', 'status_valid' => '1'], "Tahun_Masuk", "program_sekolah")['program_sekolah']:0?></td>
                  <td class="text-center"><?=(!empty(getCount('db_pmb', ['Tahun_Masuk' => $ta, 'program_sekolah' => 'S2', 'status_valid' => '0'], "Tahun_Masuk", "program_sekolah")))?getCount('db_pmb', ['Tahun_Masuk' => $ta, 'program_sekolah' => 'S2', 'status_valid' => '0'], "Tahun_Masuk", "program_sekolah")['program_sekolah']:0?></td>  
                </tr>
              </tbody>
              <tfoot></tfoot>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header border-0">
            <h3 class="card-title">Rekap Mahasiswa Baru Berdasar Program Studi</h3>
          </div>
          <div class="card-body table-responsive p-0">
            <table id="dt-prodi" class="table table-striped table-valign-middle table-sm">
              <thead>
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Jenjang</th>
                  <th class="text-center">Program Studi</th>
                  <th class="text-center">Terverikasi</th>
                  <th class="text-center">Belum Terverikasi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no = 1;
                foreach ($prodi as $tr) :
                  ?>
                  <tr>
                    <td class="text-center"><?=$no++?>.</td>
                    <td class="text-center"><?=$tr->jenj?></td>
                    <td class="text-center"><?=$tr->singkatan?></td>

                    <td class="text-center"><?=(!empty(getCount('db_pmb', ['Tahun_Masuk' => $ta, 'Prodi_Pilihan_1' => $tr->singkatan, 'status_valid' => '1'], "Tahun_Masuk", "Prodi_Pilihan_1")))?getCount('db_pmb', ['Tahun_Masuk' => $ta, 'Prodi_Pilihan_1' => $tr->singkatan, 'status_valid' => '1'], "Tahun_Masuk", "Prodi_Pilihan_1")['Prodi_Pilihan_1']:0?></td>
                    <td class="text-center"><?=(!empty(getCount('db_pmb', ['Tahun_Masuk' => $ta, 'Prodi_Pilihan_1' => $tr->singkatan, 'status_valid' => '0'], "Tahun_Masuk", "Prodi_Pilihan_1")))?getCount('db_pmb', ['Tahun_Masuk' => $ta, 'Prodi_Pilihan_1' => $tr->singkatan, 'status_valid' => '0'], "Tahun_Masuk", "Prodi_Pilihan_1")['Prodi_Pilihan_1']:0?></td>
                  </tr>
                <?php endforeach;?>
              </tbody>
              <tfoot></tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">Rekapitulasi Calon MABA S1</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">

        <div class="card card-primary">
          <div class="card-header border-0">
            <h3 class="card-title">Rekap Mahasiswa Baru Berdasar Status Verifikasi</h3>
            <div class="card-tools">

            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle table-sm">
              <thead>
                <tr>
                  <th  class="text-center">No</th>
                  <th class="text-center">Status Verifikasi</th>
                  <th class="text-center">Jumlah</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no = 1;

                foreach ($verifikasi->getResult() as $r ) {
    								# code...

                 ?>
                 <tr>
                  <td class="text-center"><?=$no++;?></td>
                  <td> <?php $j=$r->valid; if($j=="1"){echo "Terverifikasi";}elseif ($j=="0") {echo "Belum Verifikasi";	}else{echo $j;} ;?></td>
                  <td class="text-center"><?=$r->JML;?></td>
                </tr>

              <?php } ?>

            </tbody>
          </table>
        </div>
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col-md-6 -->
    <div class="col-md-6">

      <div class="card card-primary">
        <div class="card-header border-0">
          <h3 class="card-title">Rekap Mahasiswa Baru Berdasar Program</h3>
          <div class="card-tools">

          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle table-sm">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Kelas</th>
                <th class="text-center">Terverifikasi</th>
                <th class="text-center">Belum Terverifikasi</th>
                <th class="text-center">Jml</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1;

              foreach ($program->getResult() as $r ) {
    								# code...

               ?>
               <tr>
                 <td class="text-center"><?=$no++;?></td>
                 <td><?=$r->prog;?> </td>
                 <td class="text-center"><?=$r->valid;?></td>
                 <td class="text-center"><?=$r->tidak_valid;?></td>
                 <td class="text-center"><?=$r->jml;?></td>
               </tr>

             <?php } ?>

           </tbody>
         </table>
       </div>
     </div>
     <!-- /.card -->
   </div>
   <!-- /.col-md-6 -->
 </div>

 <div class="row">
  <div class="col-md-6">

    <div class="card card-primary">
      <div class="card-header border-0">
        <h3 class="card-title">Rekap Mahasiswa Baru Prodi HKI</h3>
        <div class="card-tools">

        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle table-sm">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Kelas</th>
              <th class="text-center">Terverifikasi</th>
              <th class="text-center">Belum Verifikasi</th>
              <th class="text-center">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;

            foreach ($hki->getResult() as $r ) {
    								# code...

             ?>
             <tr>
              <td class="text-center"><?=$no++;?></td>
              <td> <?=$r->kls;?></td>
              <td class="text-center"><?=$r->v;?></td>
              <td class="text-center"><?=$r->n;?></td>
              <td class="text-center"><?=$r->jml;?></td>
            </tr>

          <?php } ?>

        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card -->
</div>
    <!-- /.col-md-6 -->
    <div class="col-md-6">

      <div class="card card-primary">
        <div class="card-header border-0">
          <h3 class="card-title">Rekap Mahasiswa Baru Prodi ES</h3>
          <div class="card-tools">

          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle  table-sm">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Kelas</th>
                <th class="text-center">Terverifikasi</th>
                <th class="text-center">Belum Verifikasi</th>
                <th class="text-center">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1;

              foreach ($es->getResult() as $r ) {
        								# code...

               ?>
               <tr>
                 <td class="text-center"><?=$no++;?></td>
                 <td> <?=$r->kls;?></td>
                 <td class="text-center"><?=$r->v;?></td>
                 <td class="text-center"><?=$r->n;?></td>
                 <td class="text-center"><?=$r->jml;?></td>
               </tr>

             <?php } ?>

           </tbody>
         </table>
       </div>
     </div>
     <!-- /.card -->
   </div>
   <!-- /.col-md-6 -->
 </div>

 <div class="row">
  <div class="col-md-6">

    <div class="card card-primary">
      <div class="card-header border-0">
        <h3 class="card-title">Rekap Mahasiswa Baru Prodi PBA</h3>
        <div class="card-tools">

        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle table-sm">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Kelas</th>
              <th class="text-center">Terverifikasi</th>
              <th class="text-center">Belum Verifikasi</th>
              <th class="text-center">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;

            foreach ($pba->getResult() as $r ) {
        								# code...

             ?>
             <tr>
              <td class="text-center"><?=$no++;?></td>
              <td> <?=$r->kls;?></td>
              <td class="text-center"><?=$r->v;?></td>
              <td class="text-center"><?=$r->n;?></td>
              <td class="text-center"><?=$r->jml;?></td>
            </tr>

          <?php } ?>

        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card -->
</div>
<!-- /.col-md-6 -->
<div class="col-md-6">

  <div class="card card-primary">
    <div class="card-header border-0">
      <h3 class="card-title">Rekap Mahasiswa Baru Prodi MPI</h3>
      <div class="card-tools">

      </div>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-striped table-valign-middle  table-sm">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Kelas</th>
            <th class="text-center">Terverifikasi</th>
            <th class="text-center">Belum Verifikasi</th>
            <th class="text-center">Jumlah</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1;

          foreach ($mpi->getResult() as $r ) {
        								# code...

           ?>
           <tr>
             <td class="text-center"><?=$no++;?></td>
             <td> <?=$r->kls;?></td>
             <td class="text-center"><?=$r->v;?></td>
             <td class="text-center"><?=$r->n;?></td>
             <td class="text-center"><?=$r->jml;?></td>
           </tr>

         <?php } ?>

       </tbody>
     </table>
   </div>
 </div>
 <!-- /.card -->
</div>
<!-- /.col-md-6 -->
</div>

<div class="row">
  <div class="col-md-6">

    <div class="card card-primary">
      <div class="card-header border-0">
        <h3 class="card-title">Rekap Mahasiswa Baru Prodi PGMI</h3>
        <div class="card-tools">

        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle table-sm">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Kelas</th>
              <th class="text-center">Terverifikasi</th>
              <th class="text-center">Belum Verifikasi</th>
              <th class="text-center">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;

            foreach ($pgmi->getResult() as $r ) {
        								# code...

             ?>
             <tr>
              <td class="text-center"><?=$no++;?></td>
              <td> <?=$r->kls;?></td>
              <td class="text-center"><?=$r->v;?></td>
              <td class="text-center"><?=$r->n;?></td>
              <td class="text-center"><?=$r->jml;?></td>
            </tr>

          <?php } ?>

        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card -->
</div>
<!-- /.col-md-6 -->
<div class="col-md-6">

  <div class="card card-primary">
    <div class="card-header border-0">
      <h3 class="card-title">Rekap Mahasiswa Baru Prodi IAT</h3>
      <div class="card-tools">

      </div>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-striped table-valign-middle  table-sm">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Kelas</th>
            <th class="text-center">Terverifikasi</th>
            <th class="text-center">Belum Verifikasi</th>
            <th class="text-center">Jumlah</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1;

          foreach ($iat->getResult() as $r ) {
        								# code...

           ?>
           <tr>
             <td class="text-center"><?=$no++;?></td>
             <td> <?=$r->kls;?></td>
             <td class="text-center"><?=$r->v;?></td>
             <td class="text-center"><?=$r->n;?></td>
             <td class="text-center"><?=$r->jml;?></td>
           </tr>

         <?php } ?>

       </tbody>
     </table>
   </div>
 </div>
 <!-- /.card -->
</div>
<!-- /.col-md-6 -->
</div>

<div class="row">
  <div class="col-md-6">

    <div class="card card-primary">
      <div class="card-header border-0">
        <h3 class="card-title">Rekap Mahasiswa Baru Prodi ILHA</h3>
        <div class="card-tools">

        </div>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle table-sm">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Kelas</th>
              <th class="text-center">Terverifikasi</th>
              <th class="text-center">Belum Verifikasi</th>
              <th class="text-center">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;

            foreach ($ilha->getResult() as $r ) {
        								# code...

             ?>
             <tr>
              <td class="text-center"><?=$no++;?></td>
              <td> <?=$r->kls;?></td>
              <td class="text-center"><?=$r->v;?></td>
              <td class="text-center"><?=$r->n;?></td>
              <td class="text-center"><?=$r->jml;?></td>
            </tr>

          <?php } ?>

        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card -->
</div>
<!-- /.col-md-6 -->
<div class="col-md-6">


  <!-- /.card -->
</div>
<!-- /.col-md-6 -->
</div>
</div>
</div>
<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title">Rekapitulasi Calon MABA PASCASARJANA</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">

        <div class="card card-primary">
          <div class="card-header border-0">
            <h3 class="card-title">Rekap Mahasiswa Baru S2 Berdasar Status Verifikasi</h3>
            <div class="card-tools">

            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle table-sm">
              <thead>
                <tr>
                  <th  class="text-center">No</th>
                  <th class="text-center">Status Verifikasi</th>
                  <th class="text-center">Jumlah</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no = 1;

                foreach ($verifikasi_s2->getResult() as $r ) {
        								# code...

                 ?>
                 <tr>
                  <td class="text-center"><?=$no++;?></td>
                  <td> <?php $k=$r->valid; if($k=="1"){echo "Terverifikasi";}elseif ($k=="0") {echo "Belum Verifikasi";	}else{echo $k;} ;?></td>
                  <td class="text-center"><?=$r->JML;?></td>
                </tr>

              <?php } ?>

            </tbody>
          </table>
        </div>
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col-md-6 -->
    <div class="col-md-6">

      <div class="card card-primary">
        <div class="card-header border-0">
          <h3 class="card-title">Rekap Mahasiswa Baru S2 Berdasar Prodi</h3>
          <div class="card-tools">

          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle table-sm">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Prodi</th>
                <th class="text-center">Terverifikasi</th>
                <th class="text-center">Belum Terverifikasi</th>
                <th class="text-center">Jml</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1;

              foreach ($prodi_s2->getResult() as $r ) {
        								# code...

               ?>
               <tr>
                 <td class="text-center"><?=$no++;?></td>
                 <td><?=$r->prodi;?> </td>
                 <td class="text-center"><?=$r->valid;?></td>
                 <td class="text-center"><?=$r->tidak_valid;?></td>
                 <td class="text-center"><?=$r->jml;?></td>
               </tr>

             <?php } ?>

           </tbody>
         </table>
       </div>
     </div>
     <!-- /.card -->
   </div>
   <!-- /.col-md-6 -->
 </div>

</div>
</div>


<script type="text/javascript">
  $(function() {
    //Tabel Global
    let table_glob = $('#dt-global');
    //menjumlah baris
    table_glob.find('thead tr').append('<th class="text-center" style="width: 20%">Jumlah</th>');
    table_glob.find('tbody tr').each(function(){
      var sum=0;
      $(this).find('td').each(function(index){
        if(index !== 0 && !isNaN(Number($(this).text()))){
          sum=sum+Number($(this).text());
        }
      });
      $(this).append('<td class="text-center">'+sum+'</td>');
    });
    //menjumlah kolom
    table_glob.find('tfoot').append('<tr class="bg-primary" ><th colspan="2" class="text-center">JML</th></tr>');
    var length = table_glob.find('tbody tr:last-child td').length;
    
    for(var i=2;i<length;i++){
      var sum=0;
      table_glob.find('tbody tr').each(function(){
        if(!isNaN(Number($(this).find('td').eq(i).text()))){
          sum=sum+Number($(this).find('td').eq(i).text());
        }
      });
      table_glob.find('tfoot tr:last-child').append('<th class="text-center">'+sum+'</th>');
    }

    //Tabel Global
    let table_prodi = $('#dt-prodi');
    //menjumlah baris
    table_prodi.find('thead tr').append('<th class="text-center" style="width: 20%">Jumlah</th>');
    table_prodi.find('tbody tr').each(function(){
      var sum=0;
      $(this).find('td').each(function(index){
        if(index !== 0 && !isNaN(Number($(this).text()))){
          sum=sum+Number($(this).text());
        }
      });
      $(this).append('<td class="text-center">'+sum+'</td>');
    });
    //menjumlah kolom
    table_prodi.find('tfoot').append('<tr class="bg-primary" ><th colspan="3" class="text-center">JML</th></tr>');
    var length = table_prodi.find('tbody tr:last-child td').length;
    
    for(var i=3;i<length;i++){
      var sum=0;
      table_prodi.find('tbody tr').each(function(){
        if(!isNaN(Number($(this).find('td').eq(i).text()))){
          sum=sum+Number($(this).find('td').eq(i).text());
        }
      });
      table_prodi.find('tfoot tr:last-child').append('<th class="text-center">'+sum+'</th>');
    }
  })
</script>
