<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Resources\City as CityResource;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $cities = City::orderBy('name')
            ->where('state_id', $request->get('state_id'))
            ->get();

        return CityResource::collection($cities);
    }

}
