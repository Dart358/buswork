<?php

// app/Controllers/AdminConductorController.php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ConductorModel;

class AdminConductorController extends ResourceController
{
    protected $modelName = 'App\Models\ConductorModel';
    protected $format = 'json';

    public function index()
    {
        $conductors = $this->model->findAll();
        return $this->respond($conductors);
    }

    public function show($id = null)
    {
        $conductor = $this->model->find($id);
        if (!$conductor) {
            return $this->failNotFound('Conductor not found');
        }
        return $this->respond($conductor);
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
            return $this->failNotFound('Conductor not found');
        }
        return $this->respondDeleted(['message' => 'Conductor deleted successfully']);
    }
}
