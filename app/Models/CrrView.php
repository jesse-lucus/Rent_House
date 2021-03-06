<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class CrrView extends Model
{
    public $timestamps = true;
    //protected $dateFormat = 'Y-m-d G:i:s.u';
    
    protected $guarded = ['id'];
    public function user():HasOne {
    	return $this->hasOne('App\Models\User');
    }
    public function crrReport():HasOne {
    	return $this->hasOne('App\Models\CrrReport');
    }

}
