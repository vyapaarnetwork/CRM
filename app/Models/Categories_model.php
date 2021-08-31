<?php

namespace App\Models;

use CodeIgniter\Model;

class Categories_model extends Model
{
    protected $table      = 'tblmain_categories';
    protected $primaryKey = 'main_cat_id';

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
    public function insertcategories($data)
    {

        if (empty($data['main_cat_id'])) {

            return $this->builder->insert($data);
        } else {
            return $this->builder->update($data, [$this->primaryKey => $data['main_cat_id']]);
        }
    }

    var $column_order = array('main_cat_id', null);
    var $column_search = array('cat_name');
    var $order = array('main_cat_id' => 'desc');

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
    public function deletecategories($ids = null)
    {
        if (!empty($ids)) {
            $this->builder->where('main_cat_id', $ids);
            return $this->builder->delete();
        } else {
            return false;
        }
    }

    public function getcategories($dataId = null)
    {
        if (!empty($dataId)) {
            $query = $this->builder->where('main_cat_id', $dataId)->get();
            return $query->getResultObject();
        } else {
            return false;
        }
    }

    public function getAllcategories()
    {

        $query = $this->builder->get();
        return $query->getResultArray();
    }
}
