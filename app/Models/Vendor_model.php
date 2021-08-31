<?php

namespace App\Models;

use CodeIgniter\Model;

class Vendor_model extends Model
{
    protected $table      = 'tblvendor_master';
    protected $primaryKey = 'vendor_id';

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

    public function checkUserNameExists($checkValue, $id = null)
    {
        if (!empty($checkValue)) {
            if(!empty($id)){
                $this->builder->where('vendor_id !=', $id);
            }
            $this->builder->where('vendor_username', $checkValue);
            return $this->builder->get()->resultID->num_rows;
        } else {
            return 0;
        }
        return 0;
    }
    public function checkEmailExists($checkValue, $id = null)
    {
        if (!empty($checkValue)) {
            if(!empty($id)){
                $this->builder->where('vendor_id !=', $id);
            }
            $email = $this->builder->where('vendor_email', $checkValue);
            return $this->builder->get()->resultID->num_rows;
        } else {
            return 0;
        }
        return 0;
    }
    public function checkPhoneNoExists($checkValue, $id = null)
    {
        if (!empty($checkValue)) {
            if(!empty($id)){
                $this->builder->where('vendor_id !=', $id);
            }
            $this->builder->where('vendor_phone', $checkValue);
            return $this->builder->get()->resultID->num_rows;
        } else {
            return 0;
        }
        return 0;
    }

    public function insertVendor($data, $id = null)
    {

        if (empty($id)) {
            return $this->builder->insert($data);
        } else {
            unset($data['vendor_email']);
            unset($data['vendor_username']);

            return $this->builder->update($data, [$this->primaryKey => $id]);
        }
    }
    public function getVendor($dataId = null)
    {
        if (!empty($dataId)) {
            $query = $this->builder->where('vendor_id', $dataId)->get();
            return $query->getResultObject();
        } else {
            return false;
        }
    }
    public function chechVendorAuth($username, $password)
    {
        $this->builder->groupStart();
        $this->builder->where('vendor_username', $username);
        $this->builder->orWhere('vendor_email', $username);
        $this->builder->orWhere('vendor_phone', $username);
        $this->builder->groupEnd();
        $this->builder->where('vendor_password', md5($password));
        $query = $this->builder->get();
        return $query->getResultArray();
    }
   

    public function verifyEmail($slug = null)
    {
        if (!empty($slug)) {
            return $this->builder->update(['vendor_verifed' => 'email'], ['vendor_slug' => $slug]);
        } else {
            return false;
        }
    }
    public function alreadyVerifyEmail($slug = null)
    {
        if (!empty($slug)) {
            $this->builder->where('vendor_verifed', 'email');
            $this->builder->where('vendor_slug', $slug);
            return $this->builder->countAllResults();
        } else {
            return false;
        }
    }
    public function getVendorForgot($user = null)
    {
        if (!empty($user)) {
            $this->builder->where('vendor_email', $user);
            return $this->builder->get()->getResultArray();
        } else {
            return false;
        }
    }

    public function changePassword($slug = null, $password = null)
    {
        if (!empty($slug) && !empty($password)) {
            return $this->builder->update(['vendor_password' => md5($password)], ['vendor_slug' => $slug]);
        } else {
            return false;
        }
    }

    var $column_order = array('vendor_name', 'vendor_phone', 'vendor_email', 'vendor_status', null);
    var $column_search = array('vendor_name', 'vendor_phone', 'vendor_email', 'vendor_status');
    var $order = array('vendor_id' => 'desc');

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
    public function deleteVendor($ids = null)
    {
        if (!empty($ids)) {
            $this->builder->where('vendor_id', $ids);
            return $this->builder->delete();
        } else {
            return false;
        }
    }
    public function updateStatus($ids, $status)
    {
        $this->builder->whereIn('vendor_id', $ids);
        return $this->builder->update(['vendor_status' => $status]);
    }
    
    public function getUserBySlug($slug = null, $array = false, $join = false)
    {
        if (!empty($slug)) {
            
            $this->builder->where('vendor_slug', $slug);
            // if($join){
            //     $this->builder->join('sm_bank_details', 'sm_bank_details.sbm_vendor_id = '.$this->table.'.vendor_id', 'left');
            // }
            if ($array) {
                return $this->builder->get()->getResultArray();
            } else {
                return $this->builder->get()->getResultObject();
            }
        } else {
            return false;
        }
    }
    public function UpdateVendorProfilePicBySlug($data = null, $slug = null)
    {
        if (!empty($slug) && !empty($data)) {
            $where = array('vendor_slug' => $slug);
            return $this->builder->update($data, $where);
        } else {
            return false;
        }
    }
    public function getAllVendors()
    {
        $this->builder->select('*');
        $this->builder->where('vendor_status', 'active');
        return $this->builder->get()->getResultArray();
    }
    public function getVendorBySlug($slug = null)
    {
        
        if(!empty($slug)){
            $this->builder->where('vendor_slug', $slug);
            return $this->builder->get()->getResultObject();
        } else {
            return false;
        }
    }

    public function getVendorBySlug2($slug = null)
    {
        
        if(!empty($slug)){
            $this->builder->where('vendor_slug', $slug);
            return  (!empty($vendor = $this->builder->get()->getResultArray()) ? $vendor[0] : []);
        } else {
            return false;
        }
    }
    public function checkSlug($checkValue)
    {
        if (!empty($checkValue)) {
            $this->builder->where('vendor_slug', $checkValue);
            return $this->builder->get()->resultID->num_rows;
        } else {
            return 1;
        }
        return 1;
    }
}
