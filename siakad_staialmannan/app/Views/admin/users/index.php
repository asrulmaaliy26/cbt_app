<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet"
    href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<section class="content">
    <div class="card">

        <div class="card-body">
                <form action="" method="get">
                    <div class="col-md-10 offset-md-1">
                        <div class="row mb-3">
                        	<div class="col-md-2">
                                <div class="form-group">
                                    <label>Per Hlm:</label>
                                    <select name="jml_baris" id="jml_baris" class="select2" style="width: 100%;">
                                        
                                        <option value="10" <?=(isset($jml_baris) && $jml_baris==10)?'selected':''?>>10</option>
                                        <option value="20" <?=(isset($jml_baris) && $jml_baris==20)?'selected':''?>>20</option>
                                        <option value="50" <?=(isset($jml_baris) && $jml_baris==50)?'selected':''?>>50</option>
                                        <option value="100" <?=(isset($jml_baris) && $jml_baris==100)?'selected':''?>>100</option>
                                        <option value="200" <?=(isset($jml_baris) && $jml_baris==200)?'selected':''?>>200</option>
                                        <option value="500" <?=(isset($jml_baris) && $jml_baris==500)?'selected':''?>>500</option>

                                    
                                    </select>
                                </div>
                            </div>
                            <!--
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Group:</label>
                                    <select name="user_group" id="user_group" class="select2" style="width: 100%;">
                                        <option></option>
                                        <?php $userGroup = dataDinamis('auth_groups', null, null, null, null, 'name', ['Guru', 'Wali Kelas', 'Siswa Baru', 'Panitia PPDB']); 
                                            foreach ($userGroup as $key ) {
                                        ?>
                                        <option value="<?=$key->id?>"><?=$key->name?></option>
                                        <?php    }    ?>
                                    </select>
                                </div>
                            </div>
                            -->
                            <div class="col-md-7">
                            	<div class="form-group">
                                    <label>Kata Kunci:</label>
		                            <div class="input-group ">
		                                <input name="kata_kunci" id="kata_kunci" type="search" class="form-control " placeholder="Masukkan kata kunci" value="<?=$kata_kunci;?>">
		                                <div class="input-group-append">
		                                    <button type="submit" class="btn btn-default">
		                                        <i class="fa fa-search"></i>
		                                    </button>
		                                    <a role="button" class="btn btn-success" title="Tambah User" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#tambahUserModal">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            <!--
                                            <a role="button" class="btn btn-success" title="Tambah User" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#getUserModal">
                                                <i class="fa fa-plus"></i>
                                            </a>
		                                    -->
		                                </div>
		                            </div>
		                        </div>
                            </div>
                        </div>
                        
                    </div>
                </form>
            
        </div>
    </div>
    <div class="card">

        <div class="card-body">
        	<table id="data" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="col-1 text-center">No.</th>
                        <th class="col-3 text-center">Nama Lengkap</th>
                        <th class="col-2 text-center">Username</th>
                        <th class="col-3 text-center">Email</th>
                        <th class="col-2 text-center">Group</th>
                        <th class="col-1 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        foreach ($record as $value) {
                            
                    ?>
                    <tr>
                        <td><?=$nomor++;?></td>
                        <td><?=$value['nama_lengkap'];?></td>
                        <td><?=$value['username'];?></td>
                        <td><?=$value['email'];?></td>
                        <td>
                        	<?php 
                        		$dataGroup = getUserGroup($value['id'])->getResultArray();
                        		//dd($dataGroup);
                        		foreach ($dataGroup as $key ) { ?>
                        		<a href="javascript:void(0)" class="btn btn-xs btn-primary" onclick="hapusGroup(<?=$key['group_id']?>, '<?=$key['name']?>', <?=$value['id']?>, '<?=str_replace("'","`",$value['nama_lengkap']);?>')" data-placement="top" title="Click untuk menghapus group"><?=$key['name'];?></a>
                        			
                        	<?php	}  	?>
                        		
                        </td>
                        <td>
                            <a href="javascript:void(0)" role="button" class="btn btn-xs btn-warning" data-placement="top" title="Edit" onclick="edit(<?=$value['id'];?>)"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-xs btn-success" role="button" href="javascript:void(0)" data-placement="top" title="Click untuk memasukkan user ke dalam group" onclick="tambahGroup(<?=$value['id'];?>)"><i class="fa fa-plus"></i></a>
                            <a onclick="hapus(<?=$value['id'];?>)" role="button" role="button"
                                class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <?php
                echo $pager->links('dt','datatable');
            ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="tambahModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_group" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" hidden id="id" name="id" />
                            <input type="text" class="form-control" readonly id="nama_lengkap" name="nama_lengkap" />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">

                            <input type="text" class="form-control" readonly id="username" name="username" />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" readonly id="email" name="email" />

                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">User Group</label>
                        <div class="col-sm-9">
                            <select name="group_id" id="group_id"  class="select2" onchange="changeGroup()" style="width: 100%;">
                                <option></option>
                                <?php $userGroup = dataDinamis('auth_groups'); 
                                    foreach ($userGroup as $key ) {
                                ?>
                                <option value="<?=$key->id?>"><?=$key->name?></option>
                                <?php    }    ?>
                            </select>
                            <?php
                            	//echo cmb_dinamis('group_id[]', 'auth_groups', 'name', 'id', null, null, 'id="group_id" multiple');
                            ?>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="box_folder" hidden>
                        <label class="col-sm-3 col-form-label">Folder Sistem</label>
                        <div class="col-sm-9">
                            
                            <input type="text" class="form-control" id="folder_sistem" name="folder_sistem" />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="box_fakultas" hidden>
                        <label class="col-sm-3 col-form-label">Fakultas</label>
                        <div class="col-sm-9">
                            <select name="fakultas" id="fakultas" class="select2" style="width: 100%;">
                                <option></option>
                                <?php $fak = dataDinamis('prodi', null, null, 'sing_fak'); 
                                    foreach ($fak as $key ) {
                                ?>
                                <option value="<?=$key->sing_fak?>"><?=$key->fakultas?></option>
                                <?php    }    ?>
                            </select>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="box_prodi" hidden>
                        <label class="col-sm-3 col-form-label">Prodi</label>
                        <div class="col-sm-9">
                            <select name="prodi" id="prodi" class="select2" style="width: 100%;">
                                <option></option>
                                <?php $prodi = dataDinamis('prodi'); 
                                    foreach ($prodi as $key ) {
                                ?>
                                <option value="<?=$key->singkatan?>"><?=$key->nm_prodi?></option>
                                <?php    }    ?>
                            </select>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_simpan" onclick="simpanGroup()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="getUserModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_user_lama" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Get User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jenis User</label>
                        <div class="col-sm-9">
                            <select name="nm_table" id="nm_table" class="select2" style="width: 100%;">
                                        
                                <option value="Dosen" >Dosen</option>
                                <option value="Mahasiswa" >Mahasiswa</option>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 id="judulError" hidden>Data gagal import</h4>
                            <table id="table1" class="table table-bordered table-hover">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="getUserLama()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahUserModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_user" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jenis User</label>
                        <div class="col-sm-9">
                            <select name="jns_user" id="jns_user" class="select2" style="width: 100%;">
                                        
                                <option value="data_dosen" >Dosen</option>
                                <option value="db_data_diri_mahasiswa" >Mahasiswa</option>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <select name="nama_lengkap_user" id="nama_lengkap_user" class="form-control select2">
                                
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">User Group</label>
                        <div class="col-sm-9">
                            <select name="user_group_user" id="user_group_user" class="select2" style="width: 100%;">
                                <option></option>
                                <?php $userGroup = dataDinamis('auth_groups'); 
                                    foreach ($userGroup as $key ) {
                                ?>
                                <option value="<?=$key->id?>"><?=$key->name?></option>
                                <?php    }    ?>
                            </select>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" hidden id="id_dosen_mhs" name="id_dosen_mhs" />
                            <input type="text" class="form-control"  id="username_user" name="username_user" />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  id="email_user" name="email_user" />

                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input name="password_hash" id="password_hash" type="password" placeholder="Password  Untuk Login" class="form-control">
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Konfirmasi Password</label>
                        <div class="col-sm-9">
                            <input name="confirm_password" id="confirm_password" type="password" placeholder="Ketik ulang password" class="form-control">
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="tambahUser()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_edit" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelEdit">Tambah Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" hidden id="edit_id" name="id" />
                            <input type="text" class="form-control" readonly id="edit_nama_lengkap" name="nama_lengkap" />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">

                            <input type="text" class="form-control" id="edit_username" name="username" />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_email" name="email" />

                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input name="password_baru" id="edit_password_baru" type="password" placeholder="Password Baru Untuk Login" class="form-control">
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Konfirmasi Password</label>
                        <div class="col-sm-9">
                            <input name="konfirmasi_password" id="edit_konfirmasi_password" type="password" placeholder="Ketik ulang password" class="form-control">
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpanUser()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- jQuery -->
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url('assets');?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- DataTables  & Plugins -->
<script src="<?=base_url('assets');?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


<script>

$(function() {
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $('#tambahModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
    });
    $('#tambahUserModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
    });
    $('#editModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.invalid-feedback').text('');
    });

    $('#nama_lengkap_user').select2({
        placeholder: '--- Cari Nama ---',
        minimumInputLength: 3,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getNamaCalonUserAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    tabel: $('#jns_user option:selected').val(),
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.text,
                            id: item.id,
                            id_dosen_mhs: item.id_dosen_mhs
                        }
                    }),
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    }).on('select2:select', function(e) {
        //console.log($(this).select2('data')[0]);
        //var data = $(this).find(':selected').val();
        //console.log($(this).select2('data')[0]);
        var data = $(this).select2('data')[0];
        $('#id_dosen_mhs').val(data.id_dosen_mhs);
    });
    
})

function changeGroup() {
    var val = $('#group_id option:selected').val();
    if (val == 4) {
        $('#box_prodi').attr('hidden', false);
        $('#box_fakultas').attr('hidden', true);
        $('#box_folder').attr('hidden', true);
    }else if(val == 9){
        $('#box_prodi').attr('hidden', true);
        $('#box_fakultas').attr('hidden', false);
        $('#box_folder').attr('hidden', true);
    } else if(val == 104){
        $('#box_prodi').attr('hidden', true);
        $('#box_fakultas').attr('hidden', true);
        $('#box_folder').attr('hidden', false);
    }else {
        $('#box_prodi, #box_fakultas, #box_folder').attr('hidden', true)
    }
}

function hapus(id) {
    //var link = "<?=site_url("$controller/$metode/?aksi=hapus&id=")?>" + id;
    Swal.fire({
        title: 'Are you sure?',
        text: "Data akan dipindahkan ke recycle bin!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller");?>",
                type: "post",
                data: "aksi=hapus&id=" + id,
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait!!',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    Swal.close();
                    //$(".overlay").css("display","none");
                    if (data.status) {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: "Data sudah dipindahkan ke tempat sampah"
                        })
                        location.reload();

                    } else {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: 'Data gagal dihapus'
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                    //$(".overlay").css("display","none");
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    });
}

function edit(id) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("$controller/getData");?>",
        data: "id=" + id,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#editModal').modal('show');
                $('#exampleModalLabelEdit').text('Edit User');
                $.each(response.data, function(key, value) {
                    $('#edit_' + key).val(value);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopsss',
                    text: 'blablabla'
                })
            }
        }
    })
}

function simpanUser() {

    var data = $('#form_edit').serialize();
    $('#form_edit').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/simpanUser");?>",
                type: "post",
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait!!',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    Swal.close();
                    if (data.status) {
                    	$('#tambahModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                    	if(data.error.length > 0){
                    		Swal.fire({
	                            icon: 'danger',
	                            title: 'Oopsss!!',
	                            html : 'Gagal Update: <pre><code>' +
								          JSON.stringify(data.error) +
								        '</code></pre>',
	                            confirmButtonText: 'OK',
	                            allowOutsideClick: false,
	                        });
                    	};
                    	
                        $.each(data.validation, function(key, value) {
                        	
                            $('#edit_' + key).addClass('is-invalid');

                            $('#edit_' + key).parents('.form-group').find('.invalid-feedback')
                                .text(value);
                        });
	                    

                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    })

}

function tambahUser() {

    var data = $('#form_user').serialize();
    $('#form_user').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/tambahUser");?>",
                type: "post",
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait!!',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    Swal.close();
                    if (data.msg == 'success') {
                        $('#tambahUserModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });
                    }  else if (data.msg == 'invalid') {

                        $.each(data.validation, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parents('.form-group').find('.invalid-feedback')
                                .text(value);
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data gagal disimpan',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    })

}

function tambahGroup(id) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("$controller/getData");?>",
        data: "id=" + id,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#tambahModal').modal('show');
                $('#exampleModalLabel').text('Form User Group');
                $.each(response.data, function(key, value) {
                    $('#' + key).val(value);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopsss',
                    text: 'blablabla'
                })
            }
        }
    })
}

function simpanGroup() {

    var data = $('#form_group').serialize();
    $('#form_group').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/simpanGroup");?>",
                type: "post",
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait!!',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    Swal.close();
                    if (data.status) {
                    	$('#tambahModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        })
                    } else {
                        $.each(data.validation, function(key, value) {
                            $('#' + key).addClass('is-invalid');

                            $('#' + key).parents('.form-group').find('.invalid-feedback')
                                .text(value);
                        });


                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    })

}

function hapusGroup(group_id, group_name, user_id, nama_user) {
	Swal.fire({
        title: 'Anda yakin?',
        text: nama_user+" akan dihapus dari "+group_name+"!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/hapusGroup");?>",
                type: "post",
                data: "group_id=" + group_id + "&user_id="+user_id,
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait!!',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    Swal.close();
                    if (data.status) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        })

                    } else {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: 'Data gagal dihapus'
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                    //$(".overlay").css("display","none");
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    });
}

function getUserLama(){
    var data = $('#form_user_lama').serialize();
    $('#form_user').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/getUserLama");?>",
                type: "post",
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait!!',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function(data) {
                    Swal.close();
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        confirmButtonText: 'Ya',
                        allowOutsideClick: false,
                    }).then(() => {
                            location.reload();
                    });
                    if(data.listError.length > 0){
                        $('#judulError').attr('hidden', false)

                        const thead = $('#table1 thead'); 
                        const tbody = $('#table1 tbody');
                        let tr = $("<tr />");

                        $.each(Object.keys(data.listError[0]), function(_, key){
                            tr.append("<th>" + key + "</th>")
                        });
                        tr.appendTo(thead);

                        $.each(data.listError, function (_, value) {
                            tr = $("<tr />");
                            $.each(value, function(_, text){
                                tr.append("<td>" + text + "</td>")
                            });
                            tr.appendTo(tbody);
                        })

                    }else{
                        $('#getUserModal').modal('hide');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    })
}
</script>
<?=$this->endSection();?>