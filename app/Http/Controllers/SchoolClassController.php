<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->apiHandler->parseMultiple(new SchoolClass);
        
        return $result->getBuilder()->paginate();
    }

    /**
     * Store a newly created school class in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validationForStoreAction($request, [
            'grade_id' => 'required|exists:grades,id',
            'shift_id' => 'required|exists:shifts,id',
            'identifier' => 'required|string',
        ]);

        $schoolClass = SchoolClass::create($request->all());

        return $this->response->created("/schools/{$schoolClass->id}", $schoolClass);
    }

    /**
     * Display the school class resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return SchoolClass::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validationForUpdateAction($request, [
            'identifier' => 'string',
            'grade_id' => 'exists:grades,id',
            'shift_id' => 'exists:shifts,id',
        ]);

        $schoolClass = SchoolClass::findOrFail($id);
        $schoolClass->update($request->all());

        return $schoolClass;
    }

    /**
     * Removes school class resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schoolClass = SchoolClass::findOrFail($id);
        $schoolClass->delete();

        return $this->response->noContent();
    }
}