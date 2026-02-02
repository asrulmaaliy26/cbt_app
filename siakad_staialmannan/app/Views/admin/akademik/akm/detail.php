<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $templateJudul ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="<?= base_url('assets'); ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/dist/css/adminlte.min.css">
</head>

<body>
    <div class="wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h4 class="m-0"><?= $templateJudul ?> <?= "Tahun Akademik " . getDataRow('tahun_akademik', ['kode' => $kode_ta])['tahunAkademik'] . " " . (getDataRow('tahun_akademik', ['kode' => $kode_ta])['semester'] == '1' ? 'Gasal' : 'Genap') ?></h4>

                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tr>
                                            <th style="width:40%">Nama</th>
                                            <td><?= $nama_lengkap ?></td>
                                        </tr>
                                        <tr>
                                            <th>NIM</th>
                                            <td><?= $nim ?></td>
                                        </tr>
                                        <tr>
                                            <th>Prodi</th>
                                            <td><?= $prodi ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tr>
                                            <th style="width:40%">Tahun Angkatan</th>
                                            <td><?= $th_angkatan ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kelas</th>
                                            <td><?= $kelas ?></td>
                                        </tr>
                                        <tr>
                                            <th>Program</th>
                                            <td><?= $program ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary card-outline" id="card_mk">

                    <div class="card-body">
                        <table id="data_mk" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode MK</th>
                                    <th>Nama MK</th>
                                    <th class="text-center">SKS</th>
                                    <th class="text-center">UTS</th>
                                    <th class="text-center">TGS</th>
                                    <th class="text-center">UAS</th>
                                    <th class="text-center">P</th>
                                    <th class="text-center">N. Akhir</th>
                                    <th class="text-center">H</th>
                                    <th class="text-center">M</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- ./wrapper -->
    <!-- Page specific script -->
    <!-- jQuery -->
    <script src="<?= base_url('assets'); ?>/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url('assets'); ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- DataTables  & Plugins -->
    <script src="<?= base_url('assets'); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets'); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets'); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets'); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets'); ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url('assets'); ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets'); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>

    <!-- JSZip (sudah benar punyamu) -->
    <script src="<?= base_url('assets'); ?>/plugins/jszip/jszip.min.js"></script>


    <!-- Select2 -->
    <script src="<?= base_url('assets'); ?>/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('assets'); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?= base_url('assets'); ?>/plugins/toastr/toastr.min.js"></script>
    <!-- InputMask -->
    <script src="<?= base_url('assets'); ?>/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url('assets'); ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets'); ?>/dist/js/adminlte.js"></script>
    <script>
        var table_mk;
        $(function() {

            $('.select2').select2({
                placeholder: "----Pilih Opsi----",
                allowClear: true
            });
            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });
            table_mk = $('#data_mk').DataTable({
                dom: "<'row mb-2'<'col-md-6'B><'col-md-6 text-right'f>>" +
                    "<'row'<'col-12'tr>>",

                // buttons: [{
                //     extend: 'excelHtml5',
                //     text: '<i class="fas fa-file-excel"></i> Export Excel',
                //     className: 'btn btn-success btn-sm',
                //     title: 'Detail Nilai AKM',
                //     exportOptions: {
                //         columns: ':visible'
                //     }
                // }],
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Export Excel',
                    className: 'btn btn-success btn-sm',

                    // 🔹 JUDUL di dalam file Excel
                    title: 'Detail Nilai AKM',

                    // 🔹 NAMA FILE saat download
                    filename: function() {
                        return 'Nilai_AKM_' + "<?= $nim ?>" + "_<?= date('Ymd') ?>";
                    },

                    exportOptions: {
                        columns: ':visible'
                    }
                }],

                "createdRow": function(row, data, index) {
                    $('td', row).eq(0).addClass('text-center');
                    $('td', row).eq(3).addClass('text-center');
                    $('td', row).eq(4).addClass('text-center');
                    $('td', row).eq(5).addClass('text-center');
                    $('td', row).eq(6).addClass('text-center');
                    $('td', row).eq(7).addClass('text-center');
                    $('td', row).eq(8).addClass('text-center');
                    $('td', row).eq(9).addClass('text-center');
                    $('td', row).eq(10).addClass('text-center');
                },
                "destroy": true,
                "paging": false,
                "lengthChange": false,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": true,
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url("akademik/$controller/listDetailAkm") ?>",
                    "type": "POST",
                    "data": function(data) {
                        data.id_krs = "<?= $id ?>";
                    }
                },
                "columnDefs": [{
                    "targets": [],
                    "orderable": false,
                }, ],
            });

            $('th input[type=checkbox], td input[name=check]').prop('checked', true);

            var active_class = 'active';
            $('#data_mk > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
                var th_checked = this.checked; //checkbox inside "TH" table header

                $(this).closest('table').find('tbody > tr').each(function() {
                    var row = this;
                    if (th_checked) $(row).addClass(active_class).find('input[name=check]').eq(0).prop('checked', true);
                    else $(row).removeClass(active_class).find('input[name=check]').eq(0).prop('checked', false);
                });
            });

        })
    </script>
</body>

</html>