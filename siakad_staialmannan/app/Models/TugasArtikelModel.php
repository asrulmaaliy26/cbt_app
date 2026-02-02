<?php

namespace App\Models;

use CodeIgniter\Model;

class TugasArtikelModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tugas_artikel';
    protected $primaryKey       = 'id_artikel';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'judul', 'abstrak', 'fokus', 'review', 'posisi', 'novelty', 'metode', 'kesimpulan', 'referensi', 'sistematika', 'file_artikel', 'tgl'];

    public function simpanData($record)
    {
        
        $builder = $this->table($this->table);
        
        if (isset($record['id_artikel'])) {
            //Update data 
            $builder->save($record);
            return true;
        } else {
            //Simpan data pertama kali 
            $builder->set('id', 'UUID()', FALSE);
            if($builder->save($record)){
                return true;
            }else{
                return false;
            }
            //return $id;
        }
        /*
        if($aksi){
            return $id;
        }else{
            return false;
        }*/
    }
}
