<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    //protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'email', 'password_hash', 'nama_lengkap', 'reset_hash', 'level', 'password_plain', 'foto_profil'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function listUser($jumlah_baris, $kata_kunci = null, $group_dataset = null){
        
        $builder = $this->table($this->table);
        //$kata_kunci = Hello World
        $arr_katakunci = explode(" ", (string)$kata_kunci);
        // query = "select * from post where post_type='artikel' and (post_title like '%hello%' or post_description like '%hello%')";
        $builder->groupStart();
        for($x=0; $x<count($arr_katakunci); $x++){
            $builder->orLike('username', $arr_katakunci[$x]);
            $builder->orLike('nama_lengkap', $arr_katakunci[$x]);
        }
        $builder->groupEnd();
        $builder->where('deleted_at', null);
        $builder->where('username !=', 'rosian42');
        //$builder->join('auth_groups_users', 'auth_groups_users.user_id=users.id', 'left');
        //$builder->join('auth_groups', 'auth_groups.id=auth_groups_users.group_id', 'left');
        //$builder->orderBy('post_time', 'desc');
        $data['record'] = $builder->paginate($jumlah_baris, $group_dataset);
        $data['pager'] = $builder->pager;
        return $data;
    }
    
    function set_username($nama_lengkap){
		$builder = $this->table($this->table);
		$username = strtolower(str_replace(" ", "_",preg_replace("/[^a-zA-Z\s]+/", "", $nama_lengkap)));
		
		$builder->where('username', $username);
		$jumlah = $builder->countAllResults();
		if($jumlah > 0){
			$jumlah = $jumlah + 1;
			return $username."-".$jumlah;
		}

		return $username;
	}
    
}
