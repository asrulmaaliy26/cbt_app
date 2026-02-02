<?php

namespace App\Models;

use CodeIgniter\Model;

class CariModel extends Model
{
    protected $dt;
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    function getData($table, $where_field="", $where_val='', $groupBy='')
    {
        $builder = $this->db->table($table);
        if($where_val){
            $builder->where($where_field, $where_val);
        }
        if($groupBy){
            $builder->groupBy($groupBy);
        }
        $query = $builder->get();
        return $query->getResult();
    }

    function getDataRow($table, $where="")
    {
        $builder = $this->db->table($table);
        if($where){
            $builder->where($where);
        }
        $query = $builder->get();
        return $query->getRowArray();
    }

    function listData($table, $where="", $orderBy="", $groupBy="", $limit="", $whereNotInField="", $whereNotInVal="", $select="", $whereInField="", $whereInVal="", $joinTable="", $joinField="")
    {
        //dd($where);
        $builder = $this->db->table($table);
        if($select){
            $builder->select($select);
        }
        if($where){
            $builder->where($where);
        }
        if($whereNotInField){
            $builder->whereNotIn($whereNotInField, $whereNotInVal);
        }
        if($whereInField){
            $builder->whereIn($whereInField, $whereInVal);
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
        if($joinTable && $joinField){
            $builder->join($joinTable, $joinField, 'left');
        }
        $query = $builder->get();
        return $query->getResult();
    }

    function getDataAutoComplete($table, $field, $param, $groupBy='', $where='', $select='')
    {
        $builder = $this->db->table($table);
        if($select){
            $builder->select($select);
        }
        if($where){
            $builder->where($where);
        }
        if($groupBy){
            $builder->groupBy($groupBy);
        }
        $query = $builder->like($field, $param, 'both')->get();
        return $query->getResult();
    }

    function getDataMahasiswaAutoComplete($table, $field1, $field2, $param, $select='', $where='')
    {
        $builder = $this->db->table($table);
        if($select){
            $builder->select($select);
        }
        if($where){
            $builder->where($where);
        }
        //if($join){
            $builder->join('histori_pddk as h','h.id_data_diri=m.id','inner');
        //}
        
        
        $query = $builder->like($field1, $param, 'both')->orLike($field2, $param, 'both')->get();
        
        return $query->getResult();
    }

    function getHistoriAutoComplete($param, $where='')
    {
        $builder = $this->db->table('histori_pddk as h');
        
        if($where){
            $builder->where($where);
        }
        
        $builder->join('db_data_diri_mahasiswa as m','h.id_data_diri=m.id','inner');
        
        $query = $builder->like('m.Nama_Lengkap', $param, 'both')->orLike('h.NIM', $param, 'both')->get();
        
        return $query->getResult();
    }
}
