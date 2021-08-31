<?php

namespace App\Models;

use CodeIgniter\Model;

class Leadsaccept_model extends Model
{
    protected $table      = 'tblleads_accept';
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
    public function acceptleads($data)
    {
    
       
       
            return $this->builder->insert($data);
       

    }
    public function accept_lead($data){

    
        $data['accept_date_time'] = date('Y-m-d h:i:s');

        return $this->builder->update($data, [$this->primaryKey => $data['lead_m_id']]);
    }

    public function getacceptleads($id){
        $vendor = $_SESSION['vendor']['vendor_slug'];
            $this->builder->where('lead_m_id', $id);
            if(!empty($vendor)){
        $this->builder->where('vendor_m_id',$vendor);
            }
        $result = $this->builder->get()->resultID->num_rows;

    
        return $result;


}
}
