<?php

namespace App\Models;

use CodeIgniter\Model;

class Admin_model extends Model
{
    protected $table      = 'tbladmin_master';

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
    public function chechAdminAuth($adminUser, $adminPassword)
    {
        $query = $this->builder->select("*")
            ->groupStart()
            ->where('admin_email', $adminUser)
            ->orWhere('admin_username', $adminUser)
            ->orWhere('admin_mobile', $adminUser)
            ->groupEnd()
            ->where('admin_password', md5($adminPassword))
            ->where('admin_status', 'active')
            ->get();
        return $query->getResultArray();
    }

    var $column_order = array('admin_name', 'admin_username', 'admin_email', 'admin_mobile', 'admin_type', null);
    var $column_search = array('admin_name', 'admin_username', 'admin_email', 'admin_mobile', 'admin_type');
    var $order = array('admin_id' => 'desc');

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
    public function checkUserNameExists($checkValue, $id = null)
    {
        if (!empty($checkValue)) {
            if (!empty($id)) {
                $this->builder->where('admin_id !=', $id);
            }
            $this->builder->where('admin_username', $checkValue);
            return $this->builder->get()->resultID->num_rows;
        } else {
            return 0;
        }
        return 0;
    }
    public function checkEmailExists($checkValue, $id = null)
    {
        if (!empty($checkValue)) {
            if (!empty($id)) {
                $this->builder->where('admin_id !=', $id);
            }
            $email = $this->builder->where('admin_email', $checkValue);
            return $this->builder->get()->resultID->num_rows;
        } else {
            return 0;
        }
        return 0;
    }
    public function checkPhoneNoExists($checkValue, $id = null)
    {
        if (!empty($checkValue)) {
            if (!empty($id)) {

                $this->builder->where('admin_id !=', $id);
            }
            $this->builder->where('admin_mobile', $checkValue);
            return $this->builder->get()->resultID->num_rows;
        } else {
            return 0;
        }
        return 0;
    }
    public function checkSlug($checkValue)
    {
        if (!empty($checkValue)) {
            $this->builder->where('admin_slug', $checkValue);
            return $this->builder->get()->resultID->num_rows;
        } else {
            return 1;
        }
        return 1;
    }
    public function insertAdmin($dataRecords, $id = null)
    {
        if (empty($id)) {
            return $this->builder->insert($dataRecords);
        } else {
            return $this->builder->update($dataRecords, ['admin_id' => $id]);
        }
    }
    public function adminDelete($deleteId)
    {
        return $this->builder->delete(["admin_id" => $deleteId]);
    }
    public function getAdmin($dataId = null)
    {
        if (!empty($dataId)) {
            $query = $this->builder->where('admin_id', $dataId)->get();
            return $query->getResultObject();
        } else {
            return false;
        }
    }
    public function getUserData($slug = null)
    {
        if (!empty($slug)) {
            $query = $this->builder->where("admin_slug", $slug)->get();
            $responce = $query->getResultObject();
            if (!empty($responce[0])) {
                return $responce[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function UploadAdminProfile($data, $sam_slug)
    {
        return $this->builder->update($data, ['admin_slug' => $sam_slug]);
    }
    public function getUserImg($slug = null)
    {
        if (!empty($slug)) {
            $this->builder->select('admin_image');
            $query = $this->builder->where("admin_slug", $slug)->get();
            $responce = $query->getResultObject();
            if (!empty($responce[0])) {
                return $responce[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function getSources()
    {
        # Sources For Leads
        $this->builder->select(['admin_id', 'admin_name']);
        $this->builder->where('admin_type !=', 'super');
        $query = $this->builder->get();
        return $query->getResultArray();
    }
    public function getUserAccess($slug)
    {
        $this->builder->where('admin_slug', $slug);
        return $this->builder->get()->getResultArray();
    }
    public function updateUserAccess($data, $slug)
    {
        if (!empty($slug)) {
            $this->builder->where('admin_slug', $slug);
            return $this->builder->update($data);
        } else {
            return false;
        }
    }
    public function getSuperAdmins()
    {
        $this->builder->where('admin_type', 'super');
        $query = $this->builder->get();
        return $query->getResultArray();
    }
}
