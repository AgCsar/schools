<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolCalendar extends Model
{
	 use SoftDeletes;

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'year', 
    	'start', 
    	'end'];

    /**
     * Get the Phases of the school calendar
     * 
     * @Relation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schoolCalendarPhases()
    {
        return $this->hasMany('App\SchoolCalendarPhase');
    }

}
