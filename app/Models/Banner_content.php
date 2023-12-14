<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner_content extends Model
{
    protected $fillable = ['banner_id','title','link','image','image'];
    public function banner(){
        return $this->belongsTo('App\Job_banner','banner_id');
    }
}
