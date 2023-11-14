<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Laravel\Sanctum\Sanctum;
use Modules\Auth\Entities\User;
use Modules\Course\Entities\Link;
use Modules\Course\Transformers\CourseResource;
use Modules\Course\Transformers\LinkResource;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            $user = User::with('courses')->find(Sanctum()->id());
            $data = CourseResource::collection($user->courses->sortByDesc('created_at'))->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }

    public function links($id)
    {
        try {
            $links = Link::where('course_id', $id)->orderBy('created_at', 'desc')->get();
            $data = LinkResource::collection($links)->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }

}
