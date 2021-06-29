<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PyramidUserRestriction extends Model
{
    use HasFactory;

    protected $table = 'AdminRestriction';

    protected $fillable = [
        'AdminID',
        'Restriction',
        'RestrictionValue'
    ];
}
