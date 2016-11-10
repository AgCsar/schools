<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends Model
{
	 use SoftDeletes;

     /**
     * 
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
    protected $fillable = [];

    /**
     * Get a SchoolCalendarPhase
     * 
     * @Relation
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolCalendarPhase()
    {
        return $this->belongsTo('App\SchoolCalendarPhase');
    }
}
