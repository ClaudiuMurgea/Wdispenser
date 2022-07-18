<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispenser extends Model
{
    protected $connection = 'mysql_master';
    protected $table = 'products_list';

    protected $fillable = [
        'Name',
        'Details',
        'Resource',
        'ResourceType',
        'ResourceVersion',
        'ProductType',
        'Cost',
        'CostMoney',
        'Amount',
        'User',
        'MaxDispensableAmount',
        'DefaultDispensableValue',
        'Temperature'
    ];
}
