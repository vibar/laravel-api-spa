<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Resources\Country as CountryResource;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $countries = Country::orderBy('name')->get();

        return CountryResource::collection($countries);
    }

}
