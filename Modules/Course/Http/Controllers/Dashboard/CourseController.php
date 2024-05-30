<?php

namespace Modules\Course\Http\Controllers\Dashboard;

use App\Traits\ImageTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Entities\User;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Link;
use Modules\Course\Http\Requests\CourseRequest;
use Modules\Type\Entities\Type;
use Modules\University\Entities\University;

class CourseController extends Controller
{
    use ImageTrait;
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
                    'level' => $query?->level?->name,
                    'university' => $query?->university?->name,
                    'users' => $query->usersPivot->count(),
                    'default' => $query->default == 1 ? 'yes' : 'no',
                    'pdf_flag' => $query->pdf ? 1 : 0,
                    'pdf' => $query->pdf_path,
                    'created_at' => $query->created_at->format('d-m-Y'),
                ];
                $btn = '<div class="d-flex">';
                if ($returns['pdf_flag'] == 1) {
                    $btn = $btn . '<a class="btn btn-dark me-1 mb-2" title="View PDF" href="' . $returns['pdf'] . '" download><i class="ti ti-file" style="margin-right:5px;"></i> View PDF</a>';
                }
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


    public function levels(Request $request)
    {
        $levels = Type::where('university_id', $request->university_id)->orderBy('id', 'desc')->get()->map(function ($query) {
            return [
                'id' => $query->id,
                'name' => $query->name,
            ];
        });

        return response()->json(view('course::course.levels', ['levels' => $levels])->render(), 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $universities = University::orderBy('created_at', 'desc')->get();
        $users = User::orderBy('created_at', 'desc')->get();
        return view('course::course.create', compact('users', 'universities'));
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
                'university_id' => $request->university_id,
                'type_id' => $request->type_id,
                'pdf' => $request->pdf ? $this->image_manipulate($request->pdf, 'courses') : null,
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
        $types = Type::where('university_id', $course->university_id)->orderBy('created_at', 'desc')->get();
        $universities = University::orderBy('created_at', 'desc')->get();
        $users = User::orderBy('created_at', 'desc')->get();
        $course->load('usersPivot');
        $course->load('links');

        return view('course::course.edit', compact('course', 'types', 'users', 'universities'));
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
                'university_id' => $request->university_id,
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
