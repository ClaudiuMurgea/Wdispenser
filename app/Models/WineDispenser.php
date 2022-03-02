<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WineDispenser extends Model
{
    use HasFactory;

    protected   $connection = 'mysql_master';
    protected   $table = 'products';
    public      $timestamps = false;

    protected $fillable = [
        'Name',
        'Details',
        'Resource',
        'ResourceType',
        'ResourceVersion',
        'Cost',
        'CostMoney',
        'Slot',
        'Amount',
        'MaxDispensableAmount',
        'DefaultDispensableValue',
        'Temperature'
    ];
}
