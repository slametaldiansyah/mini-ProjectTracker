<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actual_payment extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function invoice()
    {
    	return $this->belongsTo('App\Models\Invoice');
    }
}
