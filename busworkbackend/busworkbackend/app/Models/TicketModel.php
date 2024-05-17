<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'ticket';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'orderId', 'passengerEmail'];
    protected $returnType = 'array';
    public $timestamps = false;
}
