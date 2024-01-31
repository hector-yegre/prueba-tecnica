<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Task extends Model
{
    use HasFactory;
 
    // public function user(){ // una tarea  puede tener muchas tareas
    //     return $this->hasMany(User::class);
    // }
    protected $fillable = [
        'task_name',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
}
