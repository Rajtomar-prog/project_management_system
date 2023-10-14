<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'app_name',
        'company_name',
        'company_email',
        'company_phone',
        'address',
        'app_logo',
        'favicon'
    ];
}
