<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }
    public function progress_item()
    {
    	return $this->belongsTo('App\Models\Progress_item');
    }
    public function actual_payment()
    {
        return $this->hasMany('App\Models\Actual_payment');
    }
}
