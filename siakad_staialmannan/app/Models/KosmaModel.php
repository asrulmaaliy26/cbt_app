<?php

namespace App\Models;

use CodeIgniter\Model;

class KosmaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_kosma_kelas_perkuliahan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kd_kelas_perkuliahan', 'id_his_pdk', 'prodi', 'kelas'];

    
    
    
    
}
