<?php

namespace App\Services;

use App\Models\ScheduleModel;
use App\Models\OrderModel;
use CodeIgniter\HTTP\Exceptions\HTTPException;
use Ramsey\Uuid\Uuid;

class OrdersService
{
    protected $scheduleModel;
    protected $orderModel;

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
        $this->orderModel = new OrderModel();
    }

    public function createOrder($scheduleId, $ticketQuantity, $userId)
    {
        $schedule = $this->scheduleModel->find($scheduleId);

        if (!$schedule) {
            throw new HTTPException('Bus timing does not exist', 500);
        }

        $orderData = [
            'id' => Uuid::uuid4()->toString(),
            'amount' => $schedule['ticketPrice'] * $ticketQuantity,
            'receipt' => Uuid::uuid4()->toString(),
            'scheduleId' => $scheduleId,
            'attempts' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 'pending',
            'userId' => $userId,
        ];

        // Store order in the database
        $this->orderModel->insert($orderData);

        return $orderData;
    }

    public function updateOrder($id, $data)
    {
        if ($this->orderModel->find($id)) {
            $this->orderModel->update($id, $data);
            return $this->orderModel->find($id);
        }

        throw new HTTPException('Order not found', 404);
    }

    public function deleteOrder($id)
    {
        if ($this->orderModel->find($id)) {
            $this->orderModel->delete($id);
            return true;
        }

        throw new HTTPException('Order not found', 404);
    }

    public function getAllOrders()
    {
        return $this->orderModel->findAll();
    }

    public function getOrderById($id)
    {
        $order = $this->orderModel->find($id);
        if ($order) {
            return $order;
        }

        throw new HTTPException('Order not found', 404);
    }
}
