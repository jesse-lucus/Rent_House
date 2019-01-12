<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = true;
    //protected $dateFormat = 'Y-m-d G:i:s.u';
    
    protected $guarded = ['id'];

    public function formatted_address() 
    {
    	$address = '';

    	if($this->line_1){
    		$address = $this->line_1;
    	}
    	if($this->line_2){
    		$address = $address . "<br />" . $this->line_2;
    	}
    	if($this->city){
    		$address = $address . "<br />" . $this->city. " ".$this->state. " " . $this->zip;
    	}

    	return $address;
    }
}
