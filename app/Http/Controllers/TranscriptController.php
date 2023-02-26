<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTranscriptRequest;
use App\Http\Requests\UpdateTranscriptRequest;
use App\Models\Transcript;

class TranscriptController extends Controller
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
     * @param  \App\Http\Requests\StoreTranscriptRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTranscriptRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transcript  $transcript
     * @return \Illuminate\Http\Response
     */
    public function show(Transcript $transcript)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transcript  $transcript
     * @return \Illuminate\Http\Response
     */
    public function edit(Transcript $transcript)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTranscriptRequest  $request
     * @param  \App\Models\Transcript  $transcript
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTranscriptRequest $request, Transcript $transcript)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transcript  $transcript
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transcript $transcript)
    {
        //
    }
}
