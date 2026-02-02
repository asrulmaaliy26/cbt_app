<?php
namespace App\Models;
use CodeIgniter\Model;
class LoginModel extends Model
{
	protected $table = "users";
	protected $primaryKey = "email";
	protected $allowedFields = ['username', 'password_hash', 'nama_lengkap', 'reset_hash', 'level'];

	// Untuk ambil data
	public function getData($parameter)
	{
		$builder = $this->table($this->table);
		$builder->where('username=', $parameter);
		$builder->orWhere('email=', $parameter);
		$query = $builder->get();
		return $query->getRowArray();
	}


	// untuk update / simpan data
	public function updateData($data)
	{
		$builder = $this->table($this->table);
		if($builder->save($data)){
			return true;
		}else{
			return false;
		}
	}
}