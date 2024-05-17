<?php

namespace App\Models;

use CodeIgniter\Model;

class BusModel extends Model
{
    protected $table = 'bus';
    protected $primaryKey = 'number';
    protected $allowedFields = ['number', 'capacity', 'contractorId', 'conductorId'];
    protected $returnType = 'array';
    public $timestamps = true;
}
