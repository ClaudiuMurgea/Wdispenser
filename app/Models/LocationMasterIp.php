<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationMasterIp extends Model
{
    use HasFactory;

    protected $connection = 'mysql_main';
    protected $table = 'Mystery.MasterIP';

    protected $fillable = [
        'IP',
        'LocationID',
        'LocationName',
        'ServerType',
        'SubCompany'
    ];
}
