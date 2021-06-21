<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];

    public function contract()
    {
    	return $this->belongsTo('App\Models\Contract');
    }
    public function progress_item()
    {
    	return $this->hasMany('App\Models\Progress_item');
    }
    public function project_cost()
    {
    	return $this->hasMany('App\Models\Project_cost');
    }
    public function invoice()
    {
    	return $this->hasMany('App\Models\Invoice');
    }

    // public function getall()
    // {
    //   $data = Project::with(['contract.client'])->get();
    // 	return $data;
    // }
}
