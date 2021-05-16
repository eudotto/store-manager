<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->entity = Customer::class;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:5|max:30'
        ]);

        return response()
            ->json(
                Customer::create($request->all()),
                201
            );
    }

    public function get(int $id)
    {
        $object = Customer::with('accounts')->find($id);

        if (is_null($object)) {
            return response()->json([
                'error' => 'Entity not found'
            ], 404);
        }

        return response()->json($object);
    }
}
