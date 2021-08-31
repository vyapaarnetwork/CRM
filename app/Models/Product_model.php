<?php

namespace App\Models;

use CodeIgniter\Model;

class Product_model extends Model
{
    protected $table = 'sm_product_master';
    protected $id = 'spm_id';
    
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
    
    var $column_order = array('spm_name', 'spm_price', 'spm_sell_price', 'spm_status', null);
    var $column_search = array('spm_name', 'spm_price', 'spm_sell_price', 'spm_status', 'spm_created_at');
    var $order = array('spm_id' => 'desc');

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
    public function get_datatables($array = null, $admin = false)
    {
        if($admin){
            $this->builder->join('sm_vendor_master', 'sm_vendor_master.svm_id = sm_product_master.spm_vendor_id', 'left');
        }
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
    public function uniqueField($key = null, $value = null)
    {
        if(!empty($key)){
            $this->builder->where($key, $value);
            return $this->builder->countAllResults();
        } else {
            return false;
        }
    }
    public function insertProduct($data = null)
    {
        if(!empty($data)){
            return $this->builder->insert($data);
        } else {
            return false;
        }
    }
    public function deleteProduct($ids = null)
    {
        if(!empty($ids)){
            if(is_array($ids)){
                $this->builder->whereIn($this->id, $ids);
            } else {
                $this->builder->where($this->id, $ids);
            }
            return $this->builder->delete();
        } else {
            return false;
        }
    }
    public function UpdateStatus($ids = null, $status = null)
    {
        if(!empty($ids) && !empty($status)){
            $data['spm_status'] = $status;
            return $this->builder->update($data,['spm_id' => $ids]);
        } else {
            return false;
        }
    }
    public function getProductBySlug($slug = null)
    {
        if(!empty($slug)){
            $this->builder->join('sm_vendor_master', 'sm_vendor_master.svm_id = sm_product_master.spm_vendor_id', 'left');
            $this->builder->where('spm_slug', $slug);
            return $this->builder->get()->getResultObject();
        } else {
            return [];
        }
    }
    public function getProductForPage($search = null)
    {
        if(!empty($search)){
            $this->builder->like('spm_name',preg_replace('/[^A-Za-z0-9\-]/', '',$search));
        }
        $this->builder->join('sm_media_master', 'sm_media_master.smm_product_id = '.$this->table.'.'.$this->id, 'left');
        $this->builder->groupBy($this->id);
        return $this->builder()->get()->getResultArray();
    }
    public function getCountProductForPage($search = null)
    {
        if(!empty($search)){
            $this->builder->like('spm_name',preg_replace('/[^A-Za-z0-9\-]/', '',$search));
        }
        $this->builder->join('sm_media_master', 'sm_media_master.smm_product_id = '.$this->table.'.'.$this->id, 'left');
        $this->builder->groupBy($this->id);
        $query = $this->builder()->get();
        return $query->resultID->num_rows;
    }
}
