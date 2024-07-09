<?php

namespace App\Models\Time_Tracking; // Adjust according to your folder structure

use CodeIgniter\Model;

class TimeLogModel extends Model
{
   protected $table = 'project';
    protected $primaryKey = 'id'; // Assuming 'id' is the primary key of the project table
    protected $allowedFields = ['name']; // Adjust the fields as per your table structure

}
