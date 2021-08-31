<?php

namespace App\Models;

use CodeIgniter\Model;

class Settiing_model extends Model
{
    protected $table      = 'tblsetting_master';
    protected $primaryKey = 'setting_id';

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
    public function addSetting($data, $id = null)
    {
        if (empty($id) && !empty($data)) {
            return $this->builder->insert($data);
        } else if (!empty($data)) {
            return $this->builder->update($data, [$this->primaryKey => $id]);
        } else {
            return false;
        }
    }
    var $column_order = array('setting_name', 'setting_key', 'setting_type', 'setting_value', null);
    var $column_search = array('setting_name', 'setting_key', 'setting_type', 'setting_value');
    var $order = array('setting_id' => 'asc');

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
    public function addKeyValue($data, $id = null)
    {
        if (!empty($id) && !empty($data)) {
            return $this->builder->update($data, [$this->primaryKey => $id]);
        } else {
            return false;
        }
    }
    public function getElementType($id = null)
    {
        if (!empty($id)) {
            $this->builder->where('setting_id', $id);
            $query = $this->builder->get();
            return $query->getResultArray();
        } else {
            return false;
        }
    }
    public function settingDelete($id)
    {
        return $this->builder->delete([$this->primaryKey => $id]);
    }
    public function getSettings()
    {
        $query = $this->builder->get();
        $data = $query->getResultArray();
        if (!empty($data[0])) {
            $array = null;
            foreach($data as $key):
                $array[$key['setting_key']] = $key['setting_value'];
            endforeach;
            return $array;
        } else {
            return [];
        }
    }
}
