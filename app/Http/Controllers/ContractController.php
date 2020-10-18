<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Http\Requests\ContractStoreRequest;
use App\Http\Resources\Contract as ContractResource;

class ContractController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContractStoreRequest $request)
    {
        // TODO: refactoring with optimistic locking (avoid race condition)

        $contract = Contract::create($request->all());

        return (new ContractResource($contract))
            ->response()
            ->setStatusCode(201);
    }
}
