<?php

namespace App\Models;

use CodeIgniter\Model;

class RincianProyekModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pekerjaan_proyek';
    protected $primaryKey       = 'id_pekerjaan';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_proyek', 'parent_id', 'uraian_pekerjaan', 'estimasi_hari'];
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    function list($jumlah_baris, $kata_kunci = null, $group_dataset = null){
        
        $builder = $this->table($this->table);
        //$kata_kunci = Hello World
        $arr_katakunci = explode(" ", (string)$kata_kunci);
        // query = "select * from post where post_type='artikel' and (post_title like '%hello%' or post_description like '%hello%')";
        $builder->groupStart();
        for($x=0; $x<count($arr_katakunci); $x++){
            $builder->orLike('nama_proyek', $arr_katakunci[$x]);
        }
        $builder->groupEnd();
        //$builder->where('deleted_at', null);
        //$builder->join('auth_groups_users', 'auth_groups_users.user_id=users.id', 'left');
        //$builder->join('auth_groups', 'auth_groups.id=auth_groups_users.group_id', 'left');
        
        $builder->orderBy('id_proyek', 'desc');
        $data['record'] = $builder->paginate($jumlah_baris, $group_dataset);
        $data['pager'] = $builder->pager;
        return $data;
    }
}
