<?php

namespace App\Models;

use CodeIgniter\Model;

class Customer_model extends Model
{
    protected $table      = 'tblcustomer_master';
    protected $primaryKey = 'customer_id';

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
    public function getUnique($key = null, $value = null)
    {
        if (!empty($key) && !empty($value)) {
            $this->builder->where($key, $value);
            return $this->builder->countAllResults();
        } else {
            return false;
        }
    }

    public function checkEmailExists($checkValue, $id = null)
    {
        if (!empty($checkValue)) {
            if(!empty($id)){
                $this->builder->where('customer_id !=', $id);
            }
            $email = $this->builder->where('customer_email', $checkValue);
            return $this->builder->get()->resultID->num_rows;
        } else {
            return 0;
        }
        return 0;
    }
    

    public function insertCustomer($data, $id = null)
    {
        if (empty($id)) {
            $New_slug = rand(100000, 200000);
            $i = 1;
            for ($i = 0; $i >= $i; $i++) {
                if ($this->checkSlug($New_slug) != 0) {
                    $New_slug =  rand(100000, 200000);
                } else {
                    break;
                }
            }
            $data['customer_slug'] = $New_slug;

                    $this->builder->insert($data);
            return  $this->insertID();
            
        } else {
            $data['customer_updated_at'] = now();
            return $this->builder->update($data, [$this->primaryKey => $id]);
        }
    }
    public function getCustomer($dataId = null)
    {
        if (!empty($dataId)) {
            $query = $this->builder->where('customer_id', $dataId)->get();
            return $query->getResultArray();
        } else {
            return false;
        }
    }
   
    var $column_order = array('customer_name', 'customer_phone', 'customer_email', 'customer_company', null);
    var $column_search = array('customer_name', 'customer_phone', 'customer_email', 'customer_company');
    var $order = array('customer_id' => 'desc');

    private function _get_datatables_query($array)
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($array['search']['value']) {
                if ($i === 0) {
                    $this->builder->groupStart();
                    $this->builder->like($item, preg_replace('/[^A-Za-z0-9\-]/', '', $array['search']['value']));
                } else {
                    $this->builder->orLike($item, preg_replace('/[^A-Za-z0-9\-]/', '', $array['search']['value']));
                }

                if (count($this->column_search) - 1 == $i)
                    $this->builder->groupEnd();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->builder->orderBy($this->column_order[$array['order']['0']['column']], $array['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }
    public function get_datatables($array = null)
    {
        
        $this->_get_datatables_query($array);
        if ($array['length'])
            $this->builder->limit($array['length'], $array['start']);
        $query = $this->builder->get();
        return $query->getResultArray();

    }
    public function count_filtered($array = null)
    {
        $this->_get_datatables_query($array);
        $query = $this->builder->get();
        return $query->resultID->num_rows;
    }
    public function count_all()
    {
        return $this->builder->countAllResults();
    }
    public function get_count($email)
    {
        $this->builder->where('customer_email',$email);
        return $this->builder->get();
    }
    public function deleteCustomer($ids = null)
    {
        if (!empty($ids)) {
            $this->builder->where('customer_id', $ids);
            return $this->builder->delete();
        } else {
            return false;
        }
    }

    public function getCustomerBySlug($slug = null, $array = false, $join = false)
    {
        if (!empty($slug)) {
            
            $this->builder->where('customer_slug', $slug);
            // if($join){
            //     $this->builder->join('sm_bank_details', 'sm_bank_details.sbm_vendor_id = '.$this->table.'.vendor_id', 'left');
            // }
                return $this->builder->get()->getResultArray()[0];
         
        } else {
            return false;
        }
    }
   
    public function getAllCustomer()
    {
        $this->builder->select('*');
        return $this->builder->get()->getResultArray();
    }
    public function checkSlug($checkValue)
    {
        if (!empty($checkValue)) {
            $this->builder->where('customer_slug', $checkValue);
            return $this->builder->get()->resultID->num_rows;
        } else {
            return 1;
        }
        return 1;
    }
    public function getSearch($data){
        if($data !=''){
            $this->builder->select('customer_id,customer_name');
            if(!empty($_SESSION['vendor'])){

                $this->builder->where('customer_id',array($data['customer_id']));

            }
//            $this->builder->like('customer_name', $data['post_data']);
            $customers= $this->builder->get()->getResultArray();

            $data = array();
     foreach($customers as $customers){
        $data[] = array("id"=>$customers['customer_id'], "text"=>$customers['customer_name']);
     }
     return $data;
        
        
    } else {
        return false;
    }
}

    
}
