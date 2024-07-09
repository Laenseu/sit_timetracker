<?php

namespace App\Controllers;

use App\Models\Time_Tracking\TimeLogModel;
use CodeIgniter\HTTP\Response;

class Home extends BaseController
{
    public function index(): string
    {
        return  view("Home/index");
    }

    public function myTimes()
    {
        $model = new TimeLogModel();
        $data['timeLogs'] = $model->getTimeLogsByUserId(auth()->user()->id);

        return view('Time_Tracking/my_times', $data);
    }

    public function startTimer()
    {
        // This method can be used if you need to handle any logic when the timer starts
        return $this->response->setJSON(['status' => 'success']);
    }

    public function endTimer()
    {
        $timeLogModel = new TimeLogModel();

        $data = [
            'user_id' => auth()->user()->id,
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'duration' => $this->request->getPost('duration'),
            'task_type' => $this->request->getPost('task_type'),
            'task' => $this->request->getPost('task'),
            'project_name' => $this->request->getPost('project_name'),
            'status' => $this->request->getPost('status'),
            'product' => $this->request->getPost('product')
            
        ];

        if ($timeLogModel->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'log_id' => $timeLogModel->getInsertID()]);
        } else {
            return $this->response->setJSON(['status' => 'error'], Response::HTTP_BAD_REQUEST);
        }

    }

    
    public function saveTimeLog()
    {
        $request = service('request');

        $model = new TimeLogModel();
        $data = [
            'user_id' => auth()->user()->id,
            'start_time' => $request->getVar('start_time'),
            'end_time' => $request->getVar('end_time'),
            'duration' => $request->getVar('duration'),
            'task_type' => $request->getVar('task_type'),
            'task' => $request->getVar('task'),
            'project_name' => $request->getVar('project_name'),
            'status' => $request->getVar('status'),
            'product' => $request->getVar('product')
        ];

        $saved = $model->saveTimeLog($data);

        if ($saved) {
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'error']);
        }
    }

    public function deleteTimeLog($id)
{
    $timeLogModel = new TimeLogModel();

    if ($timeLogModel->delete($id)) {
        return $this->response->setJSON(['status' => 'success']);
    } else {
        return $this->response->setJSON(['status' => 'error'], Response::HTTP_BAD_REQUEST);
    }
}

public function project()
{
    $projectModel = new ProjectModel(); // Initialize your ProjectModel
    $data['projects'] = $projectModel->findAll(); // Fetch all projects from the database

    // Load the view with the fetched data
    return view('layouts/default', $data);
}
}
