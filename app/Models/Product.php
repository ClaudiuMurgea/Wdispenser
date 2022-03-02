<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $connection = 'mysql_master';
    protected $table = 'products_list';
    public $timestamps = false;

    protected $fillable = [
        'Name',
        'Details',
        'Resource',
        'ResourceType',
        'ProductType',
        'Cost',
        'CostMoney',
        'MaxDispensableAmount',
        'DefaultDispensableValue',
        'Temperature'
    ];
}
