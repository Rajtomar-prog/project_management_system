<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'color', 'is_active'
    ];

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'departmentable');
    }


}
