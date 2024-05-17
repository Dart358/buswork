<?php

namespace App\Models;

use CodeIgniter\Model;

class ConductorModel extends Model
{
    protected $table = 'conductor';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'name', 'phone'];
    protected $returnType = 'array';
    public $timestamps = false;
}
