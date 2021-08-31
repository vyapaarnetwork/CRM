<?php

namespace App\Models;

use CodeIgniter\Model;

class Leads_model extends Model
{
    protected $table      = 'tblleads_master';
    protected $primaryKey = 'lead_id';



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
    public function addLead($lead)
    {
        if (empty($lead['lead_id'])) {


            $lead_slug = rand(1000, 10000);
            $i = 1;
            for ($i = 0; $i >= $i; $i++) {
                if ($this->checkSlug($lead_slug) != 0) {
                    $lead_slug = random_string('sha1', 5);
                } else {
                    break;
                }
            }
            $lead['lead_slug'] = $lead_slug;
            if ($this->builder->insert($lead)) {

                return  $this->insertID();
            } else {
                return 'false';
            }
        } else {
            $lead['lead_updated_at'] = date('Y-m-d h:i:s');
            return $this->builder->update($lead, [$this->primaryKey => $lead['lead_id']]);
        }
    }

    var $column_order = array('lead_slug','lead_customer_id', 'lead_source_id', 'lead_assign_id', 'lead_maincat_name','lead_status','lead_creted_at','');
    var $column_search = array('lead_customer_id', 'lead_source_id', 'lead_assign_id', 'lead_status', 'lead_slug');
    var $order = array('lead_id' => 'desc');

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
        if (!empty($_SESSION['vendor']) && empty($_SESSION['refer'])) {

            $this->builder->where('lead_assign_id', $_SESSION['vendor']['vendor_id']);
        }
        if(!empty($_SESSION['refer'])){
            $this->builder->where('lead_by_vendor', $_SESSION['vendor']['vendor_id']);

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
            if (!empty($_SESSION['vendor']) && empty($_SESSION['refer'])) {

            $this->builder->where('lead_assign_id', $_SESSION['vendor']['vendor_id']);
        }
        if(!empty($_SESSION['refer'])){
            $this->builder->where('lead_by_vendor', $_SESSION['vendor']['vendor_id']);

        }


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
    public function getLeadData($id = null)
    {
        if (!empty($id)) {
            $this->builder->where($this->primaryKey, $id);
        }

        $query = $this->builder->get();
        return $query->getResultArray();
    }
    public function deleteLead($id = null)
    {
        if (!empty($id)) {
            $this->builder->where('lead_id', $id);
            return $this->builder->delete();
        } else {
            return false;
        }
    }
    public function getLeadDetails($id = null)
    {
        if (!empty($id)) {
            $this->builder->where('lead_slug', $id);
        }
        // $this->builder->select([$this->table.'.*','sm_user_master.*','sm_admin_master.*']);
        // $this->builder->join('sm_user_master','sm_user_master.sum_id = '.$this->table.'.slm_user_id');
        // $this->builder->join('sm_admin_master','sm_admin_master.sam_id = '.$this->table.'.slm_source_id','left');
        $query = $this->builder->get();
        return $query->getResultArray();
    }
    public function change_status($data)
    {

        if (!empty($data['lead_id'])) {
            $data['lead_updated_at'] = date('Y-m-d h:i:s');

            return $this->builder->update($data, [$this->primaryKey => $data['lead_id']]);
        } else {
            return false;
        }
    }
    public function checkSlug($checkValue)
    {
        if (!empty($checkValue)) {
            $this->builder->where('lead_slug', $checkValue);
            return $this->builder->get()->resultID->num_rows;
        } else {
            return 1;
        }
        return 1;
    }
    public function hasaccess($id){
        if(!empty($_SESSION['vendor'])){
             $this->builder->where('lead_slug', $id);
            
             $this->builder->where('lead_assign_id', $_SESSION['vendor']['vendor_id']);
             $this->builder->orwhere('lead_by_vendor', $_SESSION['vendor']['vendor_id']);

            return $this->builder->get()->resultID->num_rows;
    }

}
public  function  getVendorClient(){
        if(!empty($_SESSION['vendor'])){
            $this->builder->select('lead_customer_id');
            $this->builder->where('lead_assign_id', $_SESSION['vendor']['vendor_id']);
            $this->builder->orwhere('lead_by_vendor', $_SESSION['vendor']['vendor_id']);

            return $this->builder->get()->getResult();

        }
}
}
