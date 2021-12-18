<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class StoreCanisterLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::find(auth()->id())->can('create canister log');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'canisterQR' => 'exists:canisters,QR',
            'toDepotId' => 'exists:depots,id|required_without_all:toTransporterId,toDealerId',
            'canisters' => 'required|array|min:1',
            'canisters.*.id' => 'required|exists:canisters,id',
            'canisters.*.filled' => 'required',
            'toDealerId' => 'exists:dealers,id',
            'toTransporterId' => 'exists:transporters,id',
            'fromDepotId' => 'exists:depots,id',
            'fromDealerId' => 'exists:dealers,id',
            'fromTransporterId' => 'exists:transporters,id',

        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException( 'You are not authorised to create a canister log');
    }
}
