<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyStoreRequest;
use App\Http\Resources\Property as PropertyResource;
use App\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $properties = Property::with('contract.type', 'city.state.country')
            ->orderBy(
                $request->input('order.column', 'email'),
                $request->input('order.direction', 'asc')
            )->get();

        return PropertyResource::collection($properties);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PropertyStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PropertyStoreRequest $request)
    {
        $property = Property::create($request->all());

        return (new PropertyResource($property))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return PropertyResource
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return new PropertyResource($property);
    }
}
