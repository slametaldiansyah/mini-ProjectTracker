<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_history extends Model
{
    use HasFactory;
    protected $table='projects_history';
    protected $guarded=['id'];
}