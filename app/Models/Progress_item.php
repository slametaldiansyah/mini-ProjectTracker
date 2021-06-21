<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress_item extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }
    public function doc()
    {
    	return $this->hasMany('App\Models\Progress_doc');
    }
    public function invoice()
    {
    	return $this->hasMany('App\Models\Invoice');
    }
}
