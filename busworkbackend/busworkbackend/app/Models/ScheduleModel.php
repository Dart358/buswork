<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table = 'schedule';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'busNumber', 'checkpoints', 'from', 'to', 'departureTime', 'days', 'ticketPrice'];
    protected $returnType = 'array';
    public $timestamps = true;
}
