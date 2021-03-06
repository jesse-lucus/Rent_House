<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncUtilityAllowance extends Model
{
    // public $timestamps = true;
    //protected $dateFormat = 'Y-m-d\TH:i:s.u';



    //
    protected $guarded = ['id'];
    public $timestamps = true;

    function getLastEditedAttribute($value)
    {
    	return milliseconds_mutator($value);
    }

    function getEffectiveDateAttribute($value)
    {
    	return milliseconds_mutator($value);
    }
    function getEffectiveDate2Attribute($value)
    {
    	return milliseconds_mutator($value);
    }
}
