<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvailableCourseRequest;
use App\Http\Requests\UpdateAvailableCourseRequest;
use App\Models\AvailableCourse;

class AvailableCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAvailableCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAvailableCourseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AvailableCourse  $availableCourse
     * @return \Illuminate\Http\Response
     */
    public function show(AvailableCourse $availableCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AvailableCourse  $availableCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(AvailableCourse $availableCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAvailableCourseRequest  $request
     * @param  \App\Models\AvailableCourse  $availableCourse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAvailableCourseRequest $request, AvailableCourse $availableCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AvailableCourse  $availableCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvailableCourse $availableCourse)
    {
        //
    }
}
