<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'peo_name', 
    	'peo_birthday', 
    	'peo_gender', 
    	'peo_place_of_birth', 
    	'peo_more'];
}
