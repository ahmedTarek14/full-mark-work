<?php

namespace Modules\Course\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
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
    public function index($type_id)
    {
        // try {
        //     $user = User::with('courses')->find(Sanctum()->id());

        //     if ($user->courses->isEmpty()) {
        //         // If the user has no courses, fetch courses with default = 1
        //         $defaultCourses = Course::where('default', 1)->get();
        //         // $defaultCourses = Course::paginate(10);
        //         $data = CourseResource::collection($defaultCourses->sortByDesc('created_at'))->response()->getData(true);
        //     } else {
        //         // If the user has courses, return the user's courses
        //         $data = CourseResource::collection($user->courses->sortByDesc('created_at'))->response()->getData(true);
        //     }

        //     return api_response_success($data);
        // } catch (\Throwable $th) {
        //     return api_response_error();
        // }
        try {
            $user = User::with('courses')->find(Sanctum()->id());

            // Fetch all courses
            $allCourses = Course::where('type_id', $type_id)->orderByDesc('id')->get();

            // Use CourseResource to transform all courses and include 'is_subscribed'
            $data = CourseResource::collection($allCourses)->response()->getData(true);

            // If the user has courses, set 'is_subscribed' to true for those courses
            if (!$user->courses->isEmpty()) {
                $courseIdsSubscribed = $user->courses->pluck('id')->toArray();
                foreach ($data as &$course) {
                    if (in_array($course['id'], $courseIdsSubscribed)) {
                        $course['is_subscribed'] = true;
                    } else {
                        $course['is_subscribed'] = false;
                    }
                }
            }

            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }

    public function default($type_id)
    {
        try {
            $defaultCourses = Course::where('type_id', $type_id)->where('default', 1)->get();
            $data = CourseResource::collection($defaultCourses->sortByDesc('created_at'))->response()->getData(true);
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }

    public function links(Course $course)
    {
        try {
            $links = Link::where('course_id', $course->id)->orderBy('id', 'asc')->get();
            $data = LinkResource::collection($links)->response()->getData(true);
            return api_response_success(
                [
                    'links' => $data,
                    'pdf' => $course->pdf ? $course->pdf_path : null
                ]
            );
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}
