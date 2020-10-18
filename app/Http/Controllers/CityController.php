<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Resources\City as CityResource;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $cities = City::orderBy('name')->get();

        return CityResource::collection($cities);
    }

}
