<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>

<link rel="stylesheet" type="text/css" href="<?=base_url('elfinder/css/theme.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?=base_url('elfinder/css/elfinder.full.css'); ?>" />

<section class="content">
    
    <div class="card">

        <div class="card-body">
        	<div id="el-finder"></div>
        </div>
    </div>
</section>


<!-- jQuery -->
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url('assets');?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>

<script type="text/javascript" src="<?=base_url('elfinder/js/elfinder.full.js'); ?>"></script>


<script>

$(function() {
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $('#el-finder').elfinder({
            url: '<?=site_url('file_manager/elfinderInit'); ?>',
        }).elfinder('instance');
    
})


</script>
<?=$this->endSection();?>