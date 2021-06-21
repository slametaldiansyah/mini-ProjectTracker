<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract_history extends Model
{
    use HasFactory;
    protected $table='contracts_history';
    protected $guarded=['id'];
    
}