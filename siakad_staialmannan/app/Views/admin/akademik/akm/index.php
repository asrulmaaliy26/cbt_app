<?= $this->extend('layout/template_backend'); ?>
<?= $this->section('content'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <form action="" method="get">
                    <!--<div class="col-md-10 offset-md-1">-->
                    <div class="row ">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tahun Akademik</label>
                                <select name="tahun_akademik" id="tahun_akademik" class="form-control select2" onchange="reload_table()" style="width: 100%;">
                                    <option></option>

                                    <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC');
                                    $tAktif = (!empty(getDataRow('tahun_akademik', ['aktif' => 'y'])['kode'])) ? getDataRow('tahun_akademik', ['aktif' => 'y'])['kode'] : '';
                                    foreach ($tahunAkademik as $key) {
                                    ?>
                                        <option value="<?= $key->kode ?>" <?= (!empty($tAktif) && $tAktif == $key->kode) ? 'selected' : '' ?>><?= $key->tahunAkademik ?> <?= $key->semester == '1' ? 'Gasal' : 'Genap'; ?></option>
                                    <?php    }    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Prodi</label>
                                <?php
                                echo cmb_dinamis('prodi', 'prodi', 'singkatan', 'singkatan', null, null, 'id="prodi" onchange="reload_table()" style="width:100%;"');
                                ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Program</label>
                                <?php
                                echo cmb_dinamis('program', 'ref_option', 'opt_val', 'opt_val', null, null, 'id="program"  style="width: 100%;" onchange="reload_table()"', null, null, ['opt_group' => 'program_kuliah', 'is_aktif !=' => 'N']);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Tahun Angkatan</label>
                                <?php
                                echo cmb_dinamis('th_angkatan', 'db_data_diri_mahasiswa', 'th_angkatan', 'th_angkatan', null, null, 'id="th_angkatan" onchange="reload_table()" style="width: 100%;"', 'th_angkatan', 'th_angkatan DESC');
                                ?>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <?php
                                echo cmb_dinamis('status', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="status"  style="width: 100%;" onchange="reload_table()"', null, null, ['opt_group' => 'status_mhs', 'is_aktif !=' => 'N']);
                                ?>
                            </div>
                        </div>

                    </div>

                    <!--</div>-->
                </form>


            </div>
            <!--<div class="card-footer">
                
                <a role="button" class="btn btn-primary btn-sm" title="Update Jadwal" data-palcement="top"  href="javascript:void(0)" onclick="show_modal_jadwal()">
                    <i class="fa fa-sync"></i> Update Jadwal
                </a>
                
                <a role="button" class="btn btn-danger btn-sm" title="Hapus KRS" data-palcement="top"  href="javascript:void(0)" onclick="ekspor()">
                    <i class="fa fa-trash"></i> Hapus Data
                </a>
            </div>-->
        </div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    <?= $templateJudul ?>
                </h3>
                <div class="card-tools">
                    <!--
                        <a role="button" class="btn btn-success btn-xs" title="Tambah" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#tambahModal">
                            <i class="fa fa-plus"></i> Tambah MK
                        </a>
                    -->
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox"></th>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">NIM</th>
                                <th class="text-center">Prodi</th>
                                <th class="text-center">Program</th>
                                <th class="text-center">Agkatan</th>
                                <th class="text-center">Semester</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">SKS Smt</th>
                                <th class="text-center">SKS Total</th>
                                <th class="text-center">IPK Smt</th>
                                <th class="text-center">IPK Total</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</section>


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


<script>
    var table;
    $(function() {
        $('.select2').select2({
            placeholder: "---- Semua ----",
            allowClear: true
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });


        table = $('#data').DataTable({
            dom: "<'row mb-2'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4 text-right'f>>" +
                "<'row'<'col-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",

            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Export Excel',
                className: 'btn btn-success btn-sm',
                title: 'Detail Nilai AKM',
                filename: function() {
                    return 'Nilai_AKM_' + "<?= date('Ymd') ?>";
                },
                exportOptions: {
                    columns: ':visible'
                }
            }],
            "createdRow": function(row, data, index) {
                $('td', row).eq(0).addClass('text-center');
                $('td', row).eq(1).addClass('text-center');
                $('td', row).eq(7).addClass('text-center');
                $('td', row).eq(8).addClass('text-center');
                $('td', row).eq(9).addClass('text-center');
                $('td', row).eq(10).addClass('text-center');
                $('td', row).eq(12).addClass('text-center');
            },
            "destroy": true,
            "paging": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url("akademik/$controller/ajaxList") ?>",
                "type": "POST",
                "data": function(data) {
                    data.tahun_akademik = $('#tahun_akademik').val();
                    data.prodi = $('#prodi').val();
                    data.program = $('#program').val();
                    data.th_angkatan = $('#th_angkatan').val();
                    data.status = $('#status').val();
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });

        $('th input[type=checkbox], td input[name=check]').prop('checked', false);

        var active_class = 'active';
        $('#data > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
            var th_checked = this.checked; //checkbox inside "TH" table header

            $(this).closest('table').find('tbody > tr').each(function() {
                var row = this;
                if (th_checked) $(row).addClass(active_class).find('input[name=check]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[name=check]').eq(0).prop('checked', false);
            });
        });
    })

    function detail_akm(id_krs) {
        var link = "<?= base_url("akademik/akm/detail?id=") ?>" + id_krs;
        var iframe = '<object type="text/html" data="' + link + '" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
        //var link_cetak = "<?= base_url("keuangan/transaksi/cetak_nota?id_transaksi=") ?>"+id_trx;

        $.createModal({
            title: 'Detail Aktifitas Perkuliahan',
            message: iframe,
            //link_cetak: link_cetak,
            //id_transaksi: id_trx,
            //status_transaksi: status_trx,
            closeButton: true,
            //reload_table:true,
            //tbl_id:'table_mk',
            scrollable: false
        });
        return false;
    }

    function reload_table() {
        table.ajax.reload(null, false);
    }
</script>
<?= $this->endSection(); ?>