<?php
// app/Controllers/AdminBusController.php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BusModel;

class AdminBusController extends ResourceController
{
    protected $modelName = 'App\Models\BusModel';
    protected $format = 'json';

    public function index()
    {
        $buses = $this->model->findAll();
        return $this->respond($buses);
    }

    public function show($id = null)
    {
        $bus = $this->model->find($id);
        if (!$bus) {
            return $this->failNotFound('Bus not found');
        }
        return $this->respond($bus);
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
            return $this->failNotFound('Bus not found');
        }
        return $this->respondDeleted(['message' => 'Bus deleted successfully']);
    }
}
