<?php
/*
function kirim_email($attachment, $to, $tittle, $message)
{
	$email = \Config\Services::email();
	$email_pengirim = (empty(konfigurasi_get('email_server')['konfigurasi_value']))?konfigurasi_get('email_server')['konfigurasi_default']:konfigurasi_get('email_server')['konfigurasi_value'];
	$email_nama		= (empty(konfigurasi_get('web_title')['konfigurasi_value']))?konfigurasi_get('web_title')['konfigurasi_default']:konfigurasi_get('web_title')['konfigurasi_value'];

	$config['protocol']	= "smtp";
	$config['SMTPHost']	= (empty(konfigurasi_get('smtp_host')['konfigurasi_value']))?konfigurasi_get('smtp_host')['konfigurasi_default']:konfigurasi_get('smtp_host')['konfigurasi_value'];
	$config['SMTPUser']	= $email_pengirim;
	$config['SMTPPass']	= (empty(konfigurasi_get('password_smtp')['konfigurasi_value']))?konfigurasi_get('password_smtp')['konfigurasi_default']:konfigurasi_get('password_smtp')['konfigurasi_value'];
	$config['SMTPPort']	= (empty(konfigurasi_get('smtp_port')['konfigurasi_value']))?konfigurasi_get('smtp_port')['konfigurasi_default']:konfigurasi_get('smtp_port')['konfigurasi_value'];
	$config['SMTPCrypto']	= (empty(konfigurasi_get('smtp_crypto')['konfigurasi_value']))?konfigurasi_get('smtp_crypto')['konfigurasi_default']:konfigurasi_get('smtp_crypto')['konfigurasi_value'];
	$config['mailtype']	= (empty(konfigurasi_get('mail_type')['konfigurasi_value']))?konfigurasi_get('mail_type')['konfigurasi_default']:konfigurasi_get('mail_type')['konfigurasi_value'];

	$email->initialize($config);
	$email->setFrom($email_pengirim, $email_nama);
	$email->setTo($to);
	if($attachment){
		$email->attach($attachment);
	}
	$email->setSubject($tittle);
	$email->setMessage($message);

	if(!$email->send()){
		$data = $email->printDebugger(['headers']);
		print_r($data);
		return false;
	}else{
		return true;
	}

}
*/
//fungsi untuk memberikan nomor urut di tabel paginasi
function nomor($currentPage, $jmlBaris){
	if(is_null($currentPage)){
		$nomor = 1;
	}else{
		$nomor = 1+($jmlBaris)*($currentPage - 1);
	}
	return $nomor;
}

function tgl_indonesia($param){
	$split1 = explode(" ", $param);
	$tanggal = $split1[0];
	$waktu = $split1[1];

	$bulan = [
		'1' => 'Januari', 'Pebruari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'
	];
	$hari = [
		'1' => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'	
	];
	$split2 = explode("-", $tanggal);

	$num = date('N',strtotime($tanggal));
	return $hari[$num].", ".$split2[2]." ".$bulan[(int)$split2[1]]." ".$split2[0];
}

function tgl_indonesia_short($param){
    $split1 = explode(" ", $param);
    $tanggal = $split1[0];
    $waktu = $split1[1];

    $bulan = [
        '1' => 'Januari', 'Pebruari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'
    ];
    $hari = [
        '1' => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad' 
    ];
    $split2 = explode("-", $tanggal);

    $num = date('N',strtotime($tanggal));
    return $split2[2]." ".$bulan[(int)$split2[1]]." ".$split2[0];
}

function ubah_ke_datetime($param){
    $split1 = explode(" ", $param);
    $tanggal = $split1[0];
    $waktu = $split1[1];
    
    $split2 = explode("-", $tanggal);

    return $split2[2]."-".$split2[1]."-".$split2[0]." ".$waktu;
}

function tgl_indonesia_date($param){

	$bulan = [
		'1' => 'Januari', 'Pebruari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'
	];
	$hari = [
		'1' => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'	
	];
    if($param){
    	$split = explode("-", $param);

    	$num = date('N',strtotime($param));
    	return $hari[$num].", ".$split[2]." ".$bulan[(int)$split[1]]." ".$split[0];
    }else{
        return "";
    }
}

function short_tgl_indonesia_date($param){

	$bulan = [
		'1' => 'Januari', 'Pebruari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'
	];
	if($param){
       $split = explode("-", $param);

       return $split[2]." ".$bulan[(int)$split[1]]." ".$split[0];
   }else{
    return "";
}
}

function hari($param){

	$bulan = [
		'1' => 'Januari', 'Pebruari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'
	];
	$hari = [
		'1' => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Ahad'	
	];
	
	$num = date('N',strtotime($param));
	return $hari[$num];
}

function bersihkan_html($html){
	$config = HTMLPurifier_Config::createDefault();
	$config->set('URI.AllowedSchemes', array('data'=>true));
	$purifier = new HTMLPurifier($config);
	$clean_html = $purifier->purify($html);
	return $clean_html;
}

/* paramater konfigurasi_name = bisa diisikan semisal set_halaman_depan, set_halamana_kontak 
function konfigurasi_get($konfigurasi_name){
	$model = new \App\Models\KonfigurasiModel;
	$filter = [
		'konfigurasi_name' => $konfigurasi_name
	];
	$data = $model->getData($filter);
	if($data){
		return $data;
	}else{
		$model->updateData($filter);
		$data = $model->getData($filter);
		return $data;
	}
	//return $data;
}

function konfigurasi_set($konfigurasi_name, $data_baru)
{
	$model = new \App\Models\KonfigurasiModel;
	$dataGet = konfigurasi_get($konfigurasi_name);
	$dataUpdate = [
		'id' =>$dataGet['id'],
		'konfigurasi_name' => $konfigurasi_name,
		'konfigurasi_value' => $data_baru['konfigurasi_value'],
		'konfigurasi_group' => $data_baru['konfigurasi_group'],
		'konfigurasi_default' => $data_baru['konfigurasi_default']
	];
	$aksi = $model->updateData($dataUpdate);
	if($aksi){
		return true;
	}else{
		return false;
	}
}*/

function post_penulis($username)
{
	$model = new \App\Models\LoginModel;
	$data = $model->getData($username);
	return $data['nama_lengkap'];
}

function getDataUser($username)
{
    $model = new \App\Models\LoginModel;
    $data = $model->getData($username);
    return $data;
}
/*
function set_post_link($post_id)
{ 
	$model = new \App\Models\PostModel;
	$data = $model->getPost($post_id);
	$type = $data['post_type'];
	$seo = $data['post_title_seo'];
	return base_url($type.'/'.$seo);	
}
*/

function cmb_dinamis($name, $table, $field, $pk, $selected=null, $class=null, $extra=null, $group_by=null, $order_by=null, $where=null, $whereInField=null, $whereInVal=null)
{
	$db      = \Config\Database::connect('default');
	$builder = $db->table($table);
	if(isset($group_by)){
		$builder->groupBy($group_by);
	}
    if(isset($order_by)){
        $builder->orderBy($order_by);
    }
    if(isset($where)){
      $builder->where($where);
  }

  if(isset($whereInField)){
      $builder->whereIn($whereInField, $whereInVal);
  }
	//$ci   = get_instance();
  $cmb  = "<select name='$name' class='form-control select2 $class' $extra ><option ></option>";

  $data = $builder->get()->getResult();
  foreach ($data as $row) {
      $cmb .= "<option value='".$row->$pk."'";
		//Apabila $selected bernilai sama dengan nilai $pk maka akan bernilai selected selain itu akan bernilai null
      $cmb .= $selected == $row->$pk ? 'selected' : '';
      $cmb .= ">".$row->$field."</option>";
  }
  $cmb .= "</select>";

  return $cmb;
}

function dataDinamis($table, $where=null, $orderBy=null, $groupBy=null, $limit=null, $whereNotInField=null, $whereNotInVal=null, $select=null, $whereInField=null, $whereInVal=null, $joinTable=null, $joinField=null)
{
    $model = new \App\Models\CariModel;
    $data = $model->listData($table, $where, $orderBy, $groupBy, $limit, $whereNotInField, $whereNotInVal, $select, $whereInField, $whereInVal, $joinTable, $joinField);
    return $data;
}

function getDistinct($table, $select, $where=null)
{
    $db      = \Config\Database::connect();
    $builder = $db->table($table);
    if($where){
        $builder->where($where);
    }
    $data = $builder->distinct($select)->get()->getResult();
    return $data;
}

function getDataRow($table, $where=null, $groupBy=null, $select=null, $limit=null, $orderBy=null)
{
    $db      = \Config\Database::connect();
    $builder = $db->table($table);
    if($select){
        $builder->select($select);
    }
    if($where){
        $builder->where($where);
    }
    if($groupBy){
        $builder->groupBy($groupBy);
    }
    if($orderBy){
        $builder->orderBy($orderBy);
    }
    
    if($limit){
        $builder->limit($limit);
    }
    $data = $builder->get()->getRowArray();
    return $data;
}
function setUserGroup($data)
{
    $db      = \Config\Database::connect();
    $builder = $db->table('auth_groups_users');
    $builder->insert($data);
    //$data = $builder->get()->getRowArray();
    return true;
}
function updateUserGroup($data)
{
    $db      = \Config\Database::connect();
    $builder = $db->table('auth_groups_users');
    $builder->set('group_id', $data['group_id']);
    $builder->where('user_id', $data['user_id']);
    $builder->update();
    //$data = $builder->get()->getRowArray();
    return true;
}
function setDataDinamis($table, $data)
{
    $db      = \Config\Database::connect();
    $builder = $db->table($table);
    if($table == 'penguji_sempro'){
        $builder->set('id_penguji', 'UUID()', FALSE);
    }
    if($table == 'tugas_artikel'){
        $builder->set('id', 'UUID()', FALSE);
        $builder->insert($data);
        return true;
    }
    $builder->insert($data);
    return true;
}
function updateDataDinamis($table, $data, $where)
{
    $db      = \Config\Database::connect();
    $builder = $db->table($table);
    $builder->set($data);
    $builder->where($where);
    $builder->update();
    return true;
}
function deleteDataDinamis($table, $where)
{
    $db      = \Config\Database::connect();
    $builder = $db->table($table);
    $builder->where($where);
    $builder->delete();
    return true;
}
function getUserGroup($userId)
{
    $db      = \Config\Database::connect();
    $builder = $db->table('auth_groups_users');
    $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
    $builder->where('user_id', $userId);
    //$builder->insertBatch($data);
    $data = $builder->get()/*->getResult()*/;
    return $data;
}
function getSum($table, $field, $where=null, $groupBy=null)
{
    $db      = \Config\Database::connect();
    $builder = $db->table($table);
    $builder->selectSum($field);
    if($where){
        $builder->where($where);
    }
    if($groupBy){
        $builder->groupBy($groupBy);
    }
    $data = $builder->get()->getRowArray();
    return $data;
}

function getCount($table, $where=null, $groupBy=null, $select=null)
{
    $db      = \Config\Database::connect();
    $builder = $db->table($table);
    $builder->selectCount($select);
    if($where){
        $builder->where($where);
    }
    if($groupBy){
        $builder->groupBy($groupBy);
    }
    $data = $builder->get()->getRowArray();
    return $data;
}

function getIpk($table, $where=null, $groupBy=null, $select=null)
{
    $db      = \Config\Database::connect();
    $builder = $db->table($table);
    $builder->select($select);
    if($where){
        $builder->where($where);
    }
    if($groupBy){
        $builder->groupBy($groupBy);
    }
    $dataNilai = $builder->get()->getResult();
    $msmt =0;
    $sks=0;
    foreach ($dataNilai as $r) {
        $m = $r->Nilai_Akhir*$r->sks;
        $msmt +=$m;
        $sks += $r->sks;
    }
    $ipkSmt = ($sks != 0)?number_format($msmt/$sks,2):0;
    return $ipkSmt;
}


/*
function getPrevAlbum($galeri_id)
{
    $model = new \App\Models\GaleriDetailModel;
    $data = $model->where('galeri_id', $galeri_id)->first();
    return $data;
}

function loadPost($post_type, $pagination, $kata_kunci=null, $data_set=null)
{
    $model = new \App\Models\PostModel;
    $data = $model->listPost($post_type, $pagination, $kata_kunci, $data_set);
    return $data;
}
*/
function selisihWaktu($awal)
{
    $waktu_awal = date_create($awal);
    $waktu_akhir = date_create();

    $diff = $waktu_awal->diff($waktu_akhir);
    $Y = $diff->y;
    $m = $diff->m;
    $d = $diff->d;
    $h = $diff->h;
    $i = $diff->i;
    $s = $diff->s;
    if($h == 0){
        return $s." menit ".$i." detik";
    }
    if($d == 0){
        return $h." jam ".$s." menit ".$i." detik";
    }
    if($m == 0){
        return $d." hari ".$h." jam ".$s." menit ".$i." detik";
    }
    if($Y == 0){
        return $m." bulan ".$d." hari ".$h." jam ".$s." menit ".$i." detik";
    }
    return $Y." tahun ".$m." bulan ".$d." hari ".$h." jam ".$s." menit ".$i." detik";
}

if ( ! function_exists('tgl_indo'))
{
    function date_indo($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[0];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[2];
        return $tanggal.' '.$bulan.' '.$tahun;
    }
}

if ( ! function_exists('YMDtotglindo'))
{
    function YMDtotglindo($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.' '.$bulan.' '.$tahun;
    }
}

if ( ! function_exists('date_YMD'))
{
    function date_YMD($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[0];
        $bulan = $pecah[1];
        $tahun = $pecah[2];
        return $tahun.'-'.$bulan.'-'.$tanggal;
    }
}

if ( ! function_exists('bulan'))
{
    function bulan($bln)
    {
        switch ($bln)
        {
            case 1:
            return "Januari";
            break;
            case 2:
            return "Pebruari";
            break;
            case 3:
            return "Maret";
            break;
            case 4:
            return "April";
            break;
            case 5:
            return "Mei";
            break;
            case 6:
            return "Juni";
            break;
            case 7:
            return "Juli";
            break;
            case 8:
            return "Agustus";
            break;
            case 9:
            return "September";
            break;
            case 10:
            return "Oktober";
            break;
            case 11:
            return "Nopember";
            break;
            case 12:
            return "Desember";
            break;
            default:
            return $bln;
        }
    }
}

//Format Shortdate
if ( ! function_exists('shortdate_indo'))
{
    function shortdate_indo($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[0];
        $bulan = short_bulan($pecah[1]);
        $tahun = $pecah[2];
        return $tanggal.'/'.$bulan.'/'.$tahun;
    }
}

if ( ! function_exists('short_tgl'))
{
    function short_tgl($tgl)
    {
        switch ($tgl)
        {
            case 1:
            return "01";
            break;
            case 2:
            return "02";
            break;
            case 3:
            return "03";
            break;
            case 4:
            return "04";
            break;
            case 5:
            return "05";
            break;
            case 6:
            return "06";
            break;
            case 7:
            return "07";
            break;
            case 8:
            return "08";
            break;
            case 9:
            return "09";
            break;
            case 10:
            return "10";
            break;
            case 11:
            return "11";
            break;
            case 12:
            return "12";
            break;
            default:
            return $tgl;
        }
    }
}

if ( ! function_exists('short_bulan'))
{
    function short_bulan($bln)
    {
        switch ($bln)
        {
            case 1:
            return "01";
            break;
            case 2:
            return "02";
            break;
            case 3:
            return "03";
            break;
            case 4:
            return "04";
            break;
            case 5:
            return "05";
            break;
            case 6:
            return "06";
            break;
            case 7:
            return "07";
            break;
            case 8:
            return "08";
            break;
            case 9:
            return "09";
            break;
            case 10:
            return "10";
            break;
            case 11:
            return "11";
            break;
            case 12:
            return "12";
            break;
            default:
            return $bln;
        }
    }
}

//format bulan romawi
if ( ! function_exists('bulan_romawi'))
{
    function bulan_romawi($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[0];
        $bulan = romawi_bulan($pecah[1]);
        $tahun = $pecah[2];
        return $bulan;
    }
}
if ( ! function_exists('romawi_bulan'))
{
    function romawi_bulan($bln)
    {
        switch ($bln)
        {
            case 1:
            return "I";
            break;
            case 2:
            return "II";
            break;
            case 3:
            return "III";
            break;
            case 4:
            return "IV";
            break;
            case 5:
            return "V";
            break;
            case 6:
            return "VI";
            break;
            case 7:
            return "VII";
            break;
            case 8:
            return "VIII";
            break;
            case 9:
            return "IX";
            break;
            case 10:
            return "X";
            break;
            case 11:
            return "XI";
            break;
            case 12:
            return "XII";
            break;
        }
    }
}

//Format Medium date
if ( ! function_exists('mediumdate_indo'))
{
    function mediumdate_indo($tgl)
    {
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[0];
        $bulan = medium_bulan($pecah[1]);
        $tahun = $pecah[2];
        return $tanggal.'-'.$bulan.'-'.$tahun;
    }
}

if ( ! function_exists('medium_bulan'))
{
    function medium_bulan($bln)
    {
        switch ($bln)
        {
            case 1:
            return "Jan";
            break;
            case 2:
            return "Feb";
            break;
            case 3:
            return "Mar";
            break;
            case 4:
            return "Apr";
            break;
            case 5:
            return "Mei";
            break;
            case 6:
            return "Jun";
            break;
            case 7:
            return "Jul";
            break;
            case 8:
            return "Ags";
            break;
            case 9:
            return "Sep";
            break;
            case 10:
            return "Okt";
            break;
            case 11:
            return "Nov";
            break;
            case 12:
            return "Des";
            break;
        }
    }
}

//Long date indo Format
if ( ! function_exists('longdate_indo'))
{
    function longdate_indo($tanggal)
    {
        $ubah = gmdate($tanggal, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tgl = $pecah[0];
        $bln = $pecah[1];
        $thn = $pecah[2];
        $bulan = bulan($pecah[1]);

        $nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
        $nama_hari = "";
        if($nama=="Sunday") {$nama_hari="Minggu";}
        else if($nama=="Monday") {$nama_hari="Senin";}
        else if($nama=="Tuesday") {$nama_hari="Selasa";}
        else if($nama=="Wednesday") {$nama_hari="Rabu";}
        else if($nama=="Thursday") {$nama_hari="Kamis";}
        else if($nama=="Friday") {$nama_hari="Jumat";}
        else if($nama=="Saturday") {$nama_hari="Sabtu";}
        return $nama_hari.', '.$tgl.' '.$bulan.' '.$thn;
    }
}

//Long date indo Format dari YMD
if ( ! function_exists('longdate_indoYMD'))
{
    function longdate_indoYMD($tanggal)
    {
        $ubah = gmdate($tanggal, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tgl = $pecah[2];
        $bln = $pecah[1];
        $thn = $pecah[0];
        $bulan = bulan($pecah[1]);

        $nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
        $nama_hari = "";
        if($nama=="Sunday") {$nama_hari="Minggu";}
        else if($nama=="Monday") {$nama_hari="Senin";}
        else if($nama=="Tuesday") {$nama_hari="Selasa";}
        else if($nama=="Wednesday") {$nama_hari="Rabu";}
        else if($nama=="Thursday") {$nama_hari="Kamis";}
        else if($nama=="Friday") {$nama_hari="Jumat";}
        else if($nama=="Saturday") {$nama_hari="Sabtu";}
        return $nama_hari.', '.$tgl.' '.$bulan.' '.$thn;
    }
}

//Fungsi hari
if ( ! function_exists('hari_indo'))
{
    function hari_indo($tanggal)
    {
        $ubah = gmdate($tanggal, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tgl = $pecah[0];
        $bln = $pecah[1];
        $thn = $pecah[2];
        $bulan = bulan($pecah[1]);

        $nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
        $nama_hari = "";
        if($nama=="Sunday") {$nama_hari="Minggu";}
        else if($nama=="Monday") {$nama_hari="Senin";}
        else if($nama=="Tuesday") {$nama_hari="Selasa";}
        else if($nama=="Wednesday") {$nama_hari="Rabu";}
        else if($nama=="Thursday") {$nama_hari="Kamis";}
        else if($nama=="Friday") {$nama_hari="Jumat";}
        else if($nama=="Saturday") {$nama_hari="Sabtu";}
        return $nama_hari;
    }
}
?>
