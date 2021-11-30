<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCanisterRequest;
use App\Http\Resources\CanisterCollection;
use App\Http\Resources\CanisterResource;
use App\Http\Resources\CreatedCanisterResource;
use App\Http\Resources\UpdatedCanisterResource;
use App\Models\Canister;
use App\Http\Requests\StoreCanisterRequest;
use App\Http\Requests\UpdateCanisterRequest;
use App\Models\Depot;

class CanisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $canisters = new Canister();

        return response()->json(CanisterCollection::make($canisters->paginate()));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCanisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCanisterRequest $request)
    {
        $canister = Canister::create([
            'code' => $request->canisterCode,
            'manuf' => $request->canisterManuf,
            'manuf_date' => $request->canisterManufDate,
            'brand_id' => $request->brandId,
            'RFID' => $request->canisterRFID,
            'QR' => $request->canisterQR,
            'recertification' => $request->canisterRecertification
        ]);

        return response()->json(CreatedCanisterResource::make($canister));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Canister $canister
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Depot $depot, Canister $canister)
    {
        return response()->json([
            'data' => CanisterResource::make($canister)
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCanisterRequest $request
     * @param \App\Models\Canister $canister
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCanisterRequest $request, Depot $depot, Canister $canister)
    {
        $canister->update([
            'code' => $request->canisterCode,
            'manuf' => $request->canisterManuf,
            'manuf_date' => $request->canisterManufDate,
            'brand_id' => $request->brandId,
            'RFID' => $request->canisterRFID,
            'QR' => $request->canisterQR,
            'recertification' => $request->canisterRecertification
        ]);

        return response()->json(UpdatedCanisterResource::make($canister));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Canister $canister
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteCanisterRequest $request, Depot $depot, Canister $canister)
    {
        $canister->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted canister'
            ]
        ]);
    }
}