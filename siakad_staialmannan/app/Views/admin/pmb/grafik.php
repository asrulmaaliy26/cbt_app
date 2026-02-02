<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>

<section class="content">
    <div class="container-fluid">
        <!--Grafik S1 -->
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div id="grafikS1"  style="width: 100%; height: 400px;"> </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div id="grafikVerifiedS1"  style="width: 100%; height: 400px;"> </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div id="grafikProdiS1"  style="width: 100%; height: 400px;"> </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</section>

<!-- jQuery -->
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url('assets');?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>


<script>
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawChartS1);
    google.charts.setOnLoadCallback(drawChartVerifS1);
    google.charts.setOnLoadCallback(drawChartProdiS1);

    function drawChartS1() {

        var data = new google.visualization.arrayToDataTable([
            ['Tahun', 'Jumlah', { role: 'annotation' }], 
            <?php 
                foreach ($grafikS1 as $row){

                    echo "['".$row['Tahun_Masuk']."',".$row['jumlah'].",'".$row['jumlah']."'], ";
                }
            ?>
        ]);

        var options = {
            title: 'Grafik Mahasiswa Baru S1',
            titleTextStyle: {
                color: '#1b1b1b', // Warna teks
                fontSize: 24, // Ukuran font
                bold: true, // Tebal
                italic: true // Miring
            },
            hAxis: {
                title: 'Tahun Pendaftaran'
            },
            vAxis: {
                title: 'Jumlah'
            },

            bar: {groupWidth: "60%"},
            legend: { position: "none" },
            annotations: {
                textStyle: {
                fontName: 'Times-Roman',
                fontSize: 18,
                bold: true,
                italic: true,
                // The color of the text.
                color: '#871b47',
                // The color of the text outline.
                auraColor: '#d799ae',
                // The transparency of the text.
                opacity: 0.8
                }
            }
        };

        var chart = new google.visualization.ColumnChart(
            document.getElementById('grafikS1'));

        chart.draw(data, options);
    }

    function drawChartVerifS1() {

        var data = new google.visualization.arrayToDataTable([
            ['Tahun', 'Verified', { role: 'annotation' }, 'Unverified', { role: 'annotation' }], 
            <?php 
                foreach ($grafikVerifiedS1 as $row){

                    echo "['".$row['Tahun_Masuk']."',".$row['valid'].",'".$row['valid']."',".$row['invalid'].",'".$row['invalid']."'], ";
                }
            ?>
            
        ]);

        var options = {
            title: 'Grafik Mahasiswa Baru S1',
            titleTextStyle: {
                color: '#1b1b1b', // Warna teks
                fontSize: 24, // Ukuran font
                bold: true, // Tebal
                italic: true // Miring
            },
            hAxis: {
                title: 'Tahun Pendaftaran'
            },
            vAxis: {
                title: 'Jumlah'
            },

            bar: {groupWidth: "80%"},
            legend: { position: "bottom" },
            
            annotations: {
                textStyle: {
                fontName: 'Times-Roman',
                fontSize: 12,
                bold: true,
                italic: true,
                // The color of the text.
                color: '#871b47',
                // The color of the text outline.
                auraColor: '#d799ae',
                // The transparency of the text.
                opacity: 0.8
                }
            }
            
        };

        var chart = new google.visualization.ColumnChart(
            document.getElementById('grafikVerifiedS1'));

        chart.draw(data, options);
    }

    function drawChartProdiS1() {

        var data = new google.visualization.arrayToDataTable([
            ['Tahun', 'SI', { role: 'annotation' }, 'MPI', { role: 'annotation' }, 'IAT', { role: 'annotation' }], 
            <?php 
                foreach ($grafikProdiS1 as $row){

                    echo "['".$row['Tahun_Masuk']."',".$row['si_valid'].",'".$row['si_valid']."',".$row['mpi_valid'].",'".$row['mpi_valid']."',".$row['iat_valid'].",'".$row['iat_valid']."'], ";
                }
            ?>
            
        ]);

        var options = {
            title: 'Grafik Mahasiswa Baru S1 Berdasar Prodi dan Terverifikasi',
            titleTextStyle: {
                color: '#1b1b1b', // Warna teks
                fontSize: 18, // Ukuran font
                bold: true, // Tebal
                italic: true // Miring
            },
            hAxis: {
                title: 'Tahun Pendaftaran'
            },
            vAxis: {
                title: 'Jumlah'
            },

            bar: {groupWidth: "85%"},
            legend: { position: "bottom" },
            
            annotations: {
                textStyle: {
                fontName: 'Times-Roman',
                fontSize: 12,
                bold: true,
                italic: true,
                // The color of the text.
                color: '#871b47',
                // The color of the text outline.
                auraColor: '#d799ae',
                // The transparency of the text.
                opacity: 0.8
                }
            },
            
            
        };

        var chart = new google.visualization.ColumnChart(
            document.getElementById('grafikProdiS1'));

        chart.draw(data, options);
    }
</script>
<?=$this->endSection();?>
