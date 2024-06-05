<?php

namespace Modules\University\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\University\Entities\University;
use Modules\University\Transformers\UniversityResource;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            if (sanctum()->id()) {
                $universities = University::whereHas('courses')->orderBy('created_at', 'desc')->paginate(10);
            } else {
                $universities = University::whereHas('courses', function ($queryBuilder) {
                    $queryBuilder->where('default', 1);
                })->orderBy('created_at', 'desc')->paginate(10);
            }
            $data = UniversityResource::collection($universities)->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            dd($th);
            return api_response_error();
        }
    }
}
