<?php

namespace App\Models;

use CodeIgniter\Model;

class ContractorModel extends Model
{
    protected $table = 'contractor';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'name', 'email', 'phone', 'address'];
    protected $returnType = 'array';
    public $timestamps = false;
}
