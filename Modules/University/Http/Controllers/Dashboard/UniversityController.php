<?php

namespace Modules\University\Http\Controllers\Dashboard;

use App\Traits\ImageTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\University\Entities\University;
use Modules\University\Http\Requests\UniversityRequest;

class UniversityController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $universities = University::orderBy('created_at', 'desc')->paginate(10)
            ->through(function ($query) {
                $returns = [
                    'id' => $query->id,
                    'name' => $query->name,
                    'logo' => $query->logo_image_path,
                    'levels' => $query->levels()->count(),
                    'created_at' => $query->created_at->format('d-m-Y'),
                ];
                $btn = '<div class="d-flex">';
                $btn .= '<a href="' . route('admin.university.level.index', ['id' => $returns['id']]) . '" title="Classes" class="btn btn-success me-1 mb-2" ><i class="fas fa-info w-5 h-5"></i> Levels</a>';
                $btn .= '<a href="javascript:;" class="btn btn-primary me-1 mb-2 btn-modal-view" data-url="' . route('admin.university.edit', ['university' => $returns['id']]) . '"><i class="ti ti-edit" style="margin-right:5px;"></i> Edit</a>';
                $btn .= '<a href="javascript:;" class="btn btn-danger me-1 mb-2 delete-btn" data-url="' . route('admin.university.destroy', ['university' => $returns['id']]) . '"><i class="ti ti-trash" style="margin-right:5px;"></i> Delete</a>';
                $btn .= '</div>';
                $returns['btn'] = $btn;
                return $returns;
            });

        return view('university::index', compact('universities'));
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(UniversityRequest $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'logo' => $this->image_manipulate($request->logo, 'universities')
            ];
            University::create($data);
            return add_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(University $university)
    {
        return view('university::edit', compact('university'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UniversityRequest $request, University $university)
    {
        try {
            $data['name'] = $request->name;

            if ($request->logo) {
                $this->image_delete($university->logo, 'universities');
                $data['logo'] = $this->image_manipulate($request->logo, 'universities');
            }
            $university->update($data);
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
    public function destroy(University $university)
    {
        //
    }
}
