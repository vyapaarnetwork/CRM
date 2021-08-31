<?php

namespace App\Models;

use CodeIgniter\Model;

class VendorDetails_model extends Model
{
    protected $table      = 'tblvendor_details';
    protected $primaryKey = 'vendor_dl_id';

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
    public function vendorcompany($data)
    {
        $count = $this->checkexist($data);
    
       
        if ($count < 1) {
            return $this->builder->insert($data);
        } else {
            return $this->builder->update($data, ['vendor_m_id' => $data['vendor_m_id']]);
        }

    }
    public function checkexist($data){
        $this->builder->where('vendor_m_id', $data['vendor_m_id']);
        return $this->builder->get()->resultID->num_rows;
    }
    public function getDetails($vendor_id){
        $this->builder->where('vendor_m_id', $vendor_id[0]->vendor_id);
        $result = $this->builder->get()->getResultArray();

    if($result){
        return $result[0];
    }
    else{
        return false;
    }

        
    }
    public function getCatdetails($vendor_id){
        $this->builder->where('vendor_m_id', $vendor_id);
        $result =  $this->builder->get()->getResultArray();
        if($result){
            return $result[0]['vendor_categoriers'];

        }
        else{
            return false;
        }
        
    }
    public function getcomm($vendor_id){
        $this->builder->where('vendor_m_id', $vendor_id);
        $result =  $this->builder->get()->getResultObject();
        if($result){
            return $result;

        }
        else{
            return false;
        }
        
    }
    public function get_vendors($lead_cat){
       
        $this->builder->like('vendor_categoriers', '%%main_cat%%');
        $this->builder->like('vendor_categoriers', $lead_cat['lead_maincat_name']);
        $this->builder->like('vendor_categoriers', '%%sub_cat%%');
        $this->builder->like('vendor_categoriers', $lead_cat['lead_subcat_name']);
        $this->builder->select([$this->table.'.*','tblvendor_master.*']);
        $this->builder->join('tblvendor_master','tblvendor_master.vendor_id = '.$this->table.'.vendor_m_id');
        $this->builder->where('vendor_status','active');
        return $this->builder->get()->getResultArray();

    }



}
