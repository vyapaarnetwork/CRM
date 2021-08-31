<?php

namespace App\Models;

use CodeIgniter\Model;

class Notification_model extends Model
{
    protected $table      = 'sm_notification_master';
    protected $primaryKey = 'snm_id';
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
    public function addNotification($data)
    {
        if (!empty($data)) {
            return $this->builder->insert($data);
        } else {
            return false;
        }
    }
    public function getNotification($id = null)
    {
        if (!empty($id)) {
            $this->builder->where(['snm_notification_reciver' => $id]);
            $this->builder->orderBy('snm_id','desc');
            return $this->builder->get()->getResultArray();
        } else {
            return false;
        }
    }
    public function unReadNotification($id)
    {
        if(!empty($id)){
            $this->builder->where('snm_notification_read',0);
            $this->builder->where('snm_notification_reciver', $id);
            $query = $this->builder->countAllResults();
            return $query;
        } else {
            return 0;
        }
    }
    public function updateReadNotification($id = null){
        if(!empty($id)){
            $this->builder->update(['snm_notification_read' => 1],['snm_notification_reciver' => $id]);
        }
    }
}
