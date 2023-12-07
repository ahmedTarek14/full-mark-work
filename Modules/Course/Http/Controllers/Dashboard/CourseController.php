<?php

namespace Modules\Course\Http\Controllers\Dashboard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Entities\User;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Link;
use Modules\Course\Http\Requests\CourseRequest;
use Modules\Type\Entities\Type;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $courses = Course::orderBy('created_at', 'desc')->paginate(10)
            ->through(function ($query) {
                $returns = [
                    'id' => $query->id,
                    'name' => $query->name,
                    'class' => $query->class?->name,
                    'users' => $query->usersPivot->count(),
                    'default' => $query->default == 1 ? 'yes' : 'no',
                    'created_at' => $query->created_at->format('d-m-Y'),
                ];
                $btn = '<div class="d-flex">';
                if ($returns['default'] == 'yes') {
                    $btn = $btn . '<a class="btn btn-warning me-1 mb-2" title="Deactivated Account" href="' . route('admin.course.update_default', ['course' => $returns['id']]) . '"><i class="ti ti-minus" style="margin-right:5px;"></i> Remove Default</a>';
                } else {
                    $btn = $btn . '<a class="btn btn-success me-1 mb-2" title="Activated Account" href="' . route('admin.course.update_default', ['course' => $returns['id']]) . '"><i class="ti ti-check" style="margin-right:5px;"></i> Add Default</a>';
                }
                $btn = $btn . '<a class="btn btn-primary me-1 mb-2" href="' . route('admin.course.edit', ['course' => $returns['id']]) . '"><i class="ti ti-edit" style="margin-right:5px;"></i> Edit</a>';
                $btn .= '<a href="javascript:;" class="btn btn-danger me-1 mb-2 delete-btn" data-url="' . route('admin.course.destroy', ['course' => $returns['id']]) . '"><i class="ti ti-trash" style="margin-right:5px;"></i> Delete</a>';
                $btn .= '</div>';
                $returns['btn'] = $btn;
                return $returns;
            });

        return view('course::course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $types = Type::orderBy('created_at', 'desc')->get();
        $users = User::orderBy('created_at', 'desc')->get();
        return view('course::course.create', compact('types', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CourseRequest $request)
    {
        try {
            $course = Course::create([
                'name' => $request->course_name,
                'type_id' => $request->type_id,
            ]);

            $links = [];
            foreach ($request->link_title as $key => $title) {
                $links[] = new Link([
                    'name' => $request->link_title[$key],
                    'url' => $request->link[$key],
                ]);
            }
            $course->links()->saveMany($links);

            // Attach users to the course
            $course->usersPivot()->createMany(
                collect($request->user_id)->map(function ($userId) {
                    return ['user_id' => $userId];
                })->all()
            );

            return add_response();
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return error_response();
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Course $course)
    {
        $types = Type::orderBy('created_at', 'desc')->get();
        $users = User::orderBy('created_at', 'desc')->get();
        $course->load('usersPivot');
        $course->load('links');

        return view('course::course.edit', compact('course', 'types', 'users'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CourseRequest $request, Course $course)
    {
        try {
            $course->update([
                'name' => $request->course_name,
                'type_id' => $request->type_id,
            ]);

            // Update links
            $links = [];
            foreach ($request->link_title as $key => $title) {
                $links[] = new Link([
                    'name' => $request->link_title[$key],
                    'url' => $request->link[$key],
                ]);
            }
            $course->links()->delete(); // Delete existing links
            $course->links()->saveMany($links);

            // Sync users
            $course->usersPivot()->delete(); // Delete existing users
            $course->usersPivot()->createMany(
                collect($request->user_id)->map(function ($userId) {
                    return ['user_id' => $userId];
                })->all()
            ); // Add new users

            return update_response();
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->back();
    }
    public function update_default($id)
    {
        $course = Course::findOrFail($id);

        if ($course->default == '1') {
            $course->default = '0';
        } else {
            $course->default = '1';
        }
        $course->save();

        return redirect()->back();
    }
}
