<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_name', 'client_id', 'departments', 'budget', 'budget_type', 'curency', 'description', 'created_by', 'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_project');
    }

    public function departments(): MorphToMany
    {
        return $this->morphToMany(Department::class, 'departmentable');
    }
}
