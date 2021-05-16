<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    protected $entity;

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->entity::paginate($request->per_page);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        return response()
            ->json(
                $this->entity::create($request->all()),
                201
            );
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $id)
    {
        $object = $this->entity::find($id);
        if (is_null($object)) {
            return response()->json([
                'error' => 'Entity not found'
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
        $object = $this->entity::find($id);
        if (is_null($object)) {
            return response()->json([
                'error' => 'Entity not found'
            ], 404);
        }
        $object->fill($request->all());
        $object->save();

        return $object;
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        if (!$this->entity::destroy($id)) {
            return response()->json([
                'error' => 'Entity not found'
            ], 404);
        }

        return response()->json('', 204);
    }
}
