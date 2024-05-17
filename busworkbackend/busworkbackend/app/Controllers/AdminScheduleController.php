<?php
// app/Controllers/AdminScheduleController.php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ScheduleModel;

class AdminScheduleController extends ResourceController
{
    protected $modelName = 'App\Models\ScheduleModel';
    protected $format = 'json';

    public function index()
    {
        $schedules = $this->model->findAll();
        return $this->respond($schedules);
    }

    public function show($id = null)
    {
        $schedule = $this->model->find($id);
        if (!$schedule) {
            return $this->failNotFound('Schedule not found');
        }
        return $this->respond($schedule);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        if (!$this->model->insert($data)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respondCreated($data);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if (!$this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respond($data);
    }

    public function delete($id = null)
    {
        if (!$this->model->delete($id)) {
            return $this->failNotFound('Schedule not found');
        }
        return $this->respondDeleted(['message' => 'Schedule deleted successfully']);
    }
}
