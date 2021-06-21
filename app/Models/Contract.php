<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];

    public function client()
    {
    	return $this->belongsTo('App\Models\Client');
    }
    public function type()
    {
    	return $this->belongsTo('App\Models\Type', 'type_id', 'id');
    }
    public function doc()
    {
    	return $this->hasMany('App\Models\Contract_doc');
    }
    public function project()
    {
    	return $this->hasMany('App\Models\Project');
    }

    protected static function boot() {
    parent::boot();

    static::deleted(function ($project) {
      $project->project()->delete();
    });
  }
}
