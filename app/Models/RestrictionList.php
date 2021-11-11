<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestrictionList extends Model
{
    use HasFactory;

    protected $connection = 'mysql_main';
    protected $table = "lmi.RestrictionList";
}
