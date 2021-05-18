<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->entity = User::class;
        $this->userService = new UserService();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($request->query->get('q')) {
            return $this->entity::where('name', 'like', '%' . $request->query->get('q') . '%')
                ->paginate($request->per_page);
        }

        return parent::index($request);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:30',
            'email' => 'required',
            'password' => 'required|min:5|max:30'
        ]);

        return $this->userService->create($request);
    }
}
