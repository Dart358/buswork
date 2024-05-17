<?php

namespace App\Controllers;

use App\Models\BusModel;
use App\Models\ConductorModel;
use App\Models\ContractorModel;
use App\Models\ScheduleModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class BusController extends ResourceController
{
    protected $busModel;
    protected $conductorModel;
    protected $contractorModel;
    protected $scheduleModel;

    public function __construct()
    {
        $this->busModel = new BusModel();
        $this->conductorModel = new ConductorModel();
        $this->contractorModel = new ContractorModel();
        $this->scheduleModel = new ScheduleModel();
    }

    public function getBusSchedule(): ResponseInterface
    {
        $schedules = $this->scheduleModel->findAll();
        return $this->respond(['today' => new \DateTime(), 'schedule' => $schedules]);
    }

    public function createNewBus(): ResponseInterface
    {
        $data = $this->request->getJSON(true);
        $exists = $this->busModel->where('number', $data['number'])->first();

        if ($exists) {
            return $this->fail('Bus already exists', 400);
        }

        $this->busModel->insert($data);
        return $this->respondCreated($data);
    }

    public function getAllConductors(): ResponseInterface
    {
        $conductors = $this->conductorModel->findAll();
        return $this->respond($conductors);
    }

    public function getConductorById($id): ResponseInterface
    {
        $conductor = $this->conductorModel->find($id);

        if (!$conductor) {
            return $this->failNotFound('Conductor not found');
        }

        return $this->respond($conductor);
    }

    public function getAllContractors(): ResponseInterface
    {
        $contractors = $this->contractorModel->findAll();
        return $this->respond($contractors);
    }

    public function getContractorById($id): ResponseInterface
    {
        $contractor = $this->contractorModel->find($id);

        if (!$contractor) {
            return $this->failNotFound('Contractor not found');
        }

        return $this->respond($contractor);
    }

    public function createNewContractor(): ResponseInterface
    {
        $data = $this->request->getJSON(true);
        $this->contractorModel->insert($data);
        return $this->respondCreated($data);
    }

    public function removeContractor($id): ResponseInterface
    {
        $this->contractorModel->delete($id);
        return $this->respondDeleted(['id' => $id]);
    }

    public function createNewConductor(): ResponseInterface
    {
        $data = $this->request->getJSON(true);
        $this->conductorModel->insert($data);
        return $this->respondCreated($data);
    }

    public function removeConductor($id): ResponseInterface
    {
        $this->conductorModel->delete($id);
        return $this->respondDeleted(['id' => $id]);
    }

    public function createNewSchedule(): ResponseInterface
    {
        $data = $this->request->getJSON(true);
        $this->scheduleModel->insert($data);
        return $this->respondCreated($data);
    }

    public function adminProtected(): ResponseInterface
    {
        return $this->respond('This is admin protected route');
    }
}
