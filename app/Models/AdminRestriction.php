<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRestriction extends Model
{
    use HasFactory;

    protected $connection = 'mysql_main';
    protected $table = 'lmi.AdminRestriction';

    protected $fillable = [
        'AdminID',
        'Restriction',
        'RestrictionValue'
    ];
}
