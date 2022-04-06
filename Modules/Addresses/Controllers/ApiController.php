<?php

namespace Modules\Addresses\Controllers;

use App\Http\Controllers\Controller;
use Modules\Addresses\Requests\AddressRequest;
use Modules\Addresses\Resources\AddressResource;

class ApiController extends Controller
{
    public function index()
    {
        $addresses = auth('api')->user()->addresses()->active()->orderBy('status', 'desc')->get();
        return api_response('success', '', AddressResource::collection($addresses));
    }

    public function store(AddressRequest $request)
    {
        $address = request()->all();
        $status = request('primary') ? 2 : 1;
        $status == 2 ? auth('api')->user()->addresses()->update(['status' => 1]) : '';
        $address = auth('api')->user()->addresses()->create(['area_id' => $address['area_id'], 'address' => $address, 'status' => $status]);
        return api_response('success', __("Address added successfully"), new AddressResource($address));
    }

    public function update(AddressRequest $request, $id)
    {
        $address = request()->all();
        $user = auth('api')->user();
        $status = request('primary') ? 2 : 1;
        $status == 2 ? auth('api')->user()->addresses()->update(['status' => 1]) : '';
        $user->addresses()->findOrFail($id)->update(['area_id' => $address['area_id'], 'address' => $address, 'status' => $status]);
        $address = $user->addresses()->find($id);
        return api_response('success', __("Address updated successfully"), new AddressResource($address));
    }

    public function destroy($id)
    {
        $user = auth('api')->user();
        $user->addresses()->findOrFail($id)->update(['status' => 0]);
        $addresses = $user->addresses()->active()->get();
        return api_response('success', __('Address deleted successfully'), AddressResource::collection($addresses));
    }
}
