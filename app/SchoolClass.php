<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['scc_identifier', 'scc_grade_id', 'scc_shift_id'];

    /**
     * Get a grade record associate with the shcool class 
     *
     * @Relation
     */
    public function grade()
    {
    	return $this->belongsTo('App\Grade');
    }

    /**
     * Get a shift record associate with the shcool class 
     *
     * @Relation
     */
    public function shift()
    {
    	$this->belongsTo('App\Shift');
    }
}
