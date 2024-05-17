<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Services\OrdersService;
use CodeIgniter\HTTP\Exceptions\HTTPException;

class OrdersController extends ResourceController
{
    protected $ordersService;

    public function __construct()
    {
        $this->ordersService = new OrdersService();
    }

    public function create()
    {
        try {
            $data = $this->request->getJSON(true);

            if (!isset($data['scheduleId'], $data['ticketQuantity'])) {
                return $this->failValidationErrors('Schedule ID and Ticket Quantity are required');
            }

            $userId = $this->request->user['userId'];
            $order = $this->ordersService->createOrder($data['scheduleId'], $data['ticketQuantity'], $userId);

            return $this->respondCreated($order);
        } catch (HTTPException $e) {
            return $this->fail($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            return $this->fail('An error occurred while creating the order', 500);
        }
    }

    public function index()
    {
        try {
            $orders = $this->ordersService->getAllOrders();
            return $this->respond($orders);
        } catch (\Exception $e) {
            return $this->fail('An error occurred while fetching orders', 500);
        }
    }

    public function update($id = null)
    {
        try {
            $data = $this->request->getJSON(true);
            $order = $this->ordersService->updateOrder($id, $data);
            return $this->respond($order);
        } catch (HTTPException $e) {
            return $this->fail($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            return $this->fail('An error occurred while updating the order', 500);
        }
    }

    public function delete($id = null)
    {
        try {
            $this->ordersService->deleteOrder($id);
            return $this->respondDeleted(['message' => 'Order deleted']);
        } catch (HTTPException $e) {
            return $this->fail($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            return $this->fail('An error occurred while deleting the order', 500);
        }
    }

    public function show($id = null)
    {
        try {
            $order = $this->ordersService->getOrderById($id);
            return $this->respond($order);
        } catch (HTTPException $e) {
            return $this->fail($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            return $this->fail('An error occurred while fetching the order', 500);
        }
    }
}
