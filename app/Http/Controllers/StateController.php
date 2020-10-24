<?php

namespace App\Http\Controllers;

use App\Http\Resources\State as StateResource;
use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $states = State::orderBy('name')
            ->where('country_id', $request->get('country_id'))
            ->get();

        return StateResource::collection($states);
    }

}
