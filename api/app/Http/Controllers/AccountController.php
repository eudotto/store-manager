<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->entity = Account::class;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'value' => 'required|numeric|min:1|max:99999999.99',
            'customer' => 'required|integer',
            'credit' => 'required|numeric|min:0|max:99999999.99'
        ]);

        $accountService = new AccountService();
        $account = $accountService->create($request->all());

        return response()
            ->json(
                $account,
                201
            );
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $id)
    {
        $object = Account::with('transactions')->find($id);

        if (is_null($object)) {
            return response()->json([
                'erro' => 'Entity not found'
            ], 404);
        }

        return response()->json($object);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request)
    {
        return response()->json([
            'erro' => 'Method not allowed'
        ], 405);
    }
}
