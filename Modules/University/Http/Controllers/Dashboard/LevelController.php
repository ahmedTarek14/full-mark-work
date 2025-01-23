<?php

namespace Modules\University\Http\Controllers\Dashboard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Type\Entities\Type;
use Modules\University\Http\Requests\LevelRequest;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($id)
    {
        $types = Type::where('university_id', $id)->orderBy('created_at', 'desc')->paginate(10)
            ->through(function ($query) {
                $returns = [
                    'id' => $query->id,
                    'name' => $query->name,
                    'faculty_name' => $query?->faculty_name,
                    'created_at' => $query->created_at->format('d-m-Y'),
                ];
                $btn = '<div class="d-flex">';
                $btn .= '<a href="javascript:;" class="btn btn-primary me-1 mb-2 btn-modal-view" data-url="' . route('admin.university.level.edit', ['type' => $returns['id']]) . '"><i class="ti ti-edit" style="margin-right:5px;"></i> Edit</a>';
                $btn .= '<a href="javascript:;" class="btn btn-danger me-1 mb-2 delete-btn" data-url="' . route('admin.university.level.destroy', ['type' => $returns['id']]) . '"><i class="ti ti-trash" style="margin-right:5px;"></i> Delete</a>';
                $btn .= '</div>';
                $returns['btn'] = $btn;
                return $returns;
            });

        return view('university::level.index', compact('types', 'id'));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(LevelRequest $request, $id)
    {
        try {
            $data = [
                'university_id' => $id,
                'name' => $request['name'],
                'faculty_name' => $request['faculty'],
            ];
            Type::create($data);
            return add_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('university::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Type $type)
    {
        return view('university::level.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(LevelRequest $request, Type $type)
    {
        try {
            $data['name'] = $request->name;
            $data['faculty_name'] = $request->faculty;
            $type->update($data);
            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Type $type)
    {
        $type->delete();

        return redirect()->back();
    }
}
