<?php

namespace App\Models;

use CodeIgniter\Model;

class KonversiNilaiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'konversi_nilai';
    protected $primaryKey       = 'id_ljk_konv';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_ljk_konv', 'am_kaprodi', 'h_kaprodi', 'am_konversi', 'h_konversi'];
    
    
    
}
