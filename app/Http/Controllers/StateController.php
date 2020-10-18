<?php

namespace App\Http\Controllers;

use App\Http\Resources\State as StateResource;
use App\State;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $states = State::orderBy('name')->get();

        return StateResource::collection($states);
    }

}
