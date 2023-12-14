<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Laravel\Sanctum\Sanctum;
use Modules\Auth\Entities\User;
use Modules\Course\Entities\Course;
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

            if ($user->courses->isEmpty()) {
                // If the user has no courses, fetch courses with default = 1
                $defaultCourses = Course::where('default', 1)->get();
                $data = CourseResource::collection($defaultCourses->sortByDesc('created_at'))->response()->getData(true);
            } else {
                // If the user has courses, return the user's courses
                $data = CourseResource::collection($user->courses->sortByDesc('created_at'))->response()->getData(true);
            }

            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }

    public function default()
    {
        try {
            $defaultCourses = Course::where('default', 1)->get();
            $data = CourseResource::collection($defaultCourses->sortByDesc('created_at'))->response()->getData(true);
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
