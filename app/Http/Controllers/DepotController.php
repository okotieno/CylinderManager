<?php

namespace App\Http\Controllers;

use App\Events\DepotCreatedEvent;
use App\Http\Requests\DeleteDepotRequest;
use App\Http\Resources\CreatedDepotResource;
use App\Http\Resources\UpdatedDepotResource;
use App\Http\Resources\DepotCollection;
use App\Http\Resources\DepotResource;
use App\Models\Depot;
use App\Http\Requests\StoreDepotRequest;
use App\Http\Requests\UpdateDepotRequest;
use App\Models\StationRole;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class DepotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return DepotCollection
     */
    public function index()
    {
        $depots = new Depot();
        return DepotCollection::make($depots->paginate());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDepotRequest $request
     * @return JsonResponse
     */
    public function store(StoreDepotRequest $request)
    {
        $depot = Depot::create([
            'name' => $request->get('depotName'),
            'code' => $request->get('depotCode'),
            'EPRA_licence_no' => $request->get('depotEPRALicenceNo'),
            'location' => $request->get('depotLocation'),
        ]);
        $depot->brands()->attach($request->get('canisterBrandIds'));
        DepotCreatedEvent::dispatch($depot);

        return response()->json(
            CreatedDepotResource::make($depot)
        )->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param Depot $depot
     * @return DepotResource
     */
    public function show(Depot $depot)
    {
        return DepotResource::make($depot);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDepotRequest $request
     * @param Depot $depot
     * @return UpdatedDepotResource
     */
    public function update(UpdateDepotRequest $request, Depot $depot)
    {
        $depot->update([
            'name' => $request->get('depotName'),
            'code' => $request->get('depotCode'),
            'EPRA_licence_no' => $request->get('depotEPRALicenceNo'),
            'location' => $request->get('depotLocation'),
        ]);

        return UpdatedDepotResource::make($depot);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Depot $depot
     * @return JsonResponse
     */
    public function destroy(DeleteDepotRequest $request, Depot $depot)
    {
        $depot->brands()->detach();
        $depot->delete();
        return response()->json([
            'headers' => [
                'message' => 'Successfully deleted depot'
            ]
        ]);
    }
}
