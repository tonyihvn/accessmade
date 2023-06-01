<?php

namespace App\Http\Controllers;

use App\Models\interests;
use App\Http\Requests\StoreinterestsRequest;
use App\Http\Requests\UpdateinterestsRequest;

class InterestsController extends Controller
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
     * @param  \App\Http\Requests\StoreinterestsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreinterestsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\interests  $interests
     * @return \Illuminate\Http\Response
     */
    public function show(interests $interests)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\interests  $interests
     * @return \Illuminate\Http\Response
     */
    public function edit(interests $interests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateinterestsRequest  $request
     * @param  \App\Models\interests  $interests
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateinterestsRequest $request, interests $interests)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\interests  $interests
     * @return \Illuminate\Http\Response
     */
    public function destroy(interests $interests)
    {
        //
    }
}
