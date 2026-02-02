<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class UjianModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'master_data';
    protected $primaryKey       = 'id_ujian';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'jenis_ujian', 'semester', 'tahun', 'kd_tahun', 'status', 'cek_spp', 'stts_ujian', 'informasi'];
    
    function list($jumlah_baris, $kata_kunci = null, $group_dataset = null){
        
        $builder = $this->table($this->table);
        //$kata_kunci = Hello World
        $arr_katakunci = explode(" ", (string)$kata_kunci);
        // query = "select * from post where post_type='artikel' and (post_title like '%hello%' or post_description like '%hello%')";
        $builder->groupStart();
        for($x=0; $x<count($arr_katakunci); $x++){
            $builder->orLike('jenis_ujian', $arr_katakunci[$x]);
            $builder->orLike('tahun', $arr_katakunci[$x]);
        }
        $builder->groupEnd();
        //$builder->where('deleted_at', null);
        //$builder->join('auth_groups_users', 'auth_groups_users.user_id=users.id', 'left');
        //$builder->join('auth_groups', 'auth_groups.id=auth_groups_users.group_id', 'left');
        if(session()->get('akun_level') == 'Mahasiswa' || session()->get('akun_level') == 'Pengawas Ujian'){
            $builder->where('status', '1');
        }
        $builder->orderBy('id_ujian', 'desc');
        $data['record'] = $builder->paginate($jumlah_baris, $group_dataset);
        $data['pager'] = $builder->pager;
        return $data;
    }
}
