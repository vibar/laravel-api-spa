<?php

namespace App\Http\Controllers;

use App\ContractType;
use App\Http\Resources\ContractType as ContractTypeResource;

class ContractTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $types = ContractType::orderBy('name')->get();

        return ContractTypeResource::collection($types);
    }

}
