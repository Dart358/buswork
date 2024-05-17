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

    public function getAllOrders()
    {
        return $this->orderModel->findAll();
    }

    public function getOrderById($id)
    {
        $order = $this->orderModel->find($id);
        if (!$order) {
            throw new HTTPException('Order not found', 404);
        }
        return $order;
    }

    public function updateOrder($id, $data)
    {
        $order = $this->orderModel->find($id);
        if (!$order) {
            throw new HTTPException('Order not found', 404);
        }
        $this->orderModel->update($id, $data);
        return $this->orderModel->find($id);
    }

    public function deleteOrder($id)
    {
        $order = $this->orderModel->find($id);
        if (!$order) {
            throw new HTTPException('Order not found', 404);
        }
        $this->orderModel->delete($id);
    }

    public function paymentConfirmation()
    {
        // Implement payment confirmation logic if needed
    }
}
