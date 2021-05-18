<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * @var StoreService
     */
    private $storeService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->entity = Store::class;
        $this->storeService = new StoreService();
    }

    public function index(Request $request)
    {
        if ($request->query->get('q')) {
            return $this->entity::where('address', 'like', '%' . $request->query->get('q') . '%')
                ->orWhere('city', 'like', '%' . $request->query->get('q') . '%')
                ->orWhere('state', 'like', '%' . $request->query->get('q') . '%')
                ->paginate($request->per_page);
        }

        return parent::index($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:50',
            'address' => 'required|min:2|max:50',
            'cep' => 'required|regex:/^\d{5}-\d{3}$/i',
            'city' => 'required|min:2|max:50',
            'state' => 'required|min:2|max:50',
        ]);

        return response()
            ->json(
                $this->storeService->create($request),
                201
            );
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:50',
            'address' => 'required|min:2|max:50',
            'cep' => 'required|regex:/^\d{5}-\d{3}$/i',
            'city' => 'required|min:2|max:50',
            'state' => 'required|min:2|max:50',
        ]);

        return response()
            ->json(
                $this->storeService->update($id, $request),
                201
            );
    }
}
