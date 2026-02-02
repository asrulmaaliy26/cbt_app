<?php 
namespace App\Validations;

/**
 * 
 */
class CustomRules
{
	
	function check_password_lama(string $str, string &$error = null): bool
	{
		$model = new \App\Models\AdminModel;

		if(empty($str)){
			return true;
		}

		$username = session()->get('akun_username');
		$dataModel = $model->getData($username);

		$password = $dataModel['password_hash'];
		if(password_verify($str, $password)){
			return true;
		}else{
			return false;
		}
	}

	function check_password_lama_user(string $str, string &$error = null): bool
	{
		$model = new \App\Models\UserModel;

		if(empty($str)){
			return true;
		}

		$idUser = session()->get('akun_id');
		$dataModel = $model->find($idUser);

		$password = $dataModel['password_hash'];
		if(password_verify($str, $password)){
			return true;
		}else{
			return false;
		}
	}

	function cek_judul(string $str, string &$error = null): bool
	{
		
		$jmlKata = count(explode (" ",$str));
		if($jmlKata > 15){
			return false;
		}else{
			return true;
		}
	}

	public function cek_jumlah_kata(?string $str, string $val): bool
    {
        $val = explode(',', $val);
        $min = $val[0];
        $max = $val[1];

        $jmlKata = count(explode (" ",$str));
		if($jmlKata > $min && $jmlKata < $max){
			
			return true;
		}

        return false;
    }

}