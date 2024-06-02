<?php

namespace Modules\Type\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Type\Entities\Type;
use Modules\Type\Transformers\LevelResource;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($university_id)
    {
        try {
            $levels = Type::where('university_id', $university_id)->orderBy('created_at', 'desc')->paginate(10);
            $data = LevelResource::collection($levels)->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}
