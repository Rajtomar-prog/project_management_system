<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','priority','project_id','due_date','description','created_by','status_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_task');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    
}
