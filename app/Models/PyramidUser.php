<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PyramidUser extends Model
{
    use HasFactory;

    protected $table = 'lmi.AdminInfo';

    protected $fillable = [
        'Login',
        'Password',
        'FirstName',
        'LastName',
        'Mobile',
        'Email',
        'MAC',
        'CanLogBack',
        'Card'
    ];
}