<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table      = 'bookings';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['user_id', 'bus_id', 'seat_number', 'booking_date'];
    protected $validationRules = [
        'user_id'       => 'required|integer',
        'bus_id'        => 'required|integer',
        'seat_number'   => 'required|integer',
        'booking_date'  => 'required|valid_date',
    ];
}
