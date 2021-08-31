<?php

namespace App\Models;

use CodeIgniter\Model;

class Leadcomment_model extends Model
{
    protected $table      = 'tblleads_comment';
    protected $primaryKey = 'lead_m_id';

    public function __construct()
    {
        $this->config = config('App');
        try {
            $this->db = \Config\Database::connect('default');
        } catch (\Exception $ex) {
            die($ex->getMessage());
        }
        $this->builder = $this->db->table($this->table);
    }
    public function leadcomment($data)
    {
    
       
       
            return $this->builder->insert($data);
       

    }

    public function getLeadComments($leadid){
        
            $this->builder->select([$this->table.'.*','tbladmin_master.admin_name','tblvendor_master.vendor_name']);
        $this->builder->join('tbladmin_master','tbladmin_master.admin_slug = '.$this->table.'.admin_m_id','left');
        $this->builder->join('tblvendor_master','tblvendor_master.vendor_slug = '.$this->table.'.vendor_m_id','left');

        $this->builder->where('lead_m_id', $leadid);
        $this->builder->orderBy('created_at','ASC');
        $result = $this->builder->get()->getResultArray();

    if($result){
        return $result;
    }
    else{
        return false;
    }

}
}
