<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRestrictionsTemplate extends Model
{
    use HasFactory;

    protected $connection = 'mysql_main';
    protected $table = 'MasterOnlyDB.AdminRestrictionsTemplates';

    protected $fillable = [
        'TemplateName',
        'Restriction',
        'RestrictionValue'
    ];
}
