<?php

namespace App\Models\Time_Tracking; // Adjust according to your folder structure

use CodeIgniter\Model;

class TimeLogModel extends Model
{
    protected $table = 'time_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'task_type', 'duration', 'task', 'project_name', 'status', 'product', 'start_time', 'end_time'];

    public function getTimeLogsByUserId($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }

    public function saveTimeLog($data)
    {
        return $this->insert($data);
    }
}
