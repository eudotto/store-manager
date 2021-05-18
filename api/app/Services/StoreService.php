<?php

namespace App\Services;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreService
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function create (Request $request)
    {
        $store = new Store();
        $store->name = $request->name;
        $store->cep = preg_replace('/\D/', '', $request->cep);
        $store->address = $request->address;
        $store->city = $request->city;
        $store->state = $request->state;
        $store->save();

        return $store;
    }

    public function update ($id, Request $request)
    {
        $store = Store::find($id);

        if (is_null($store)) {
            return response()->json([
                'error' => 'Entity not found'
            ], 404);
        }

        $data = $request->all();

        if (!empty($data['cep'])) {
            $data['cep'] = preg_replace('/\D/', '', $data['cep']);
        }

        $store->fill($data);
        $store->save();

        return $store;
    }
}
