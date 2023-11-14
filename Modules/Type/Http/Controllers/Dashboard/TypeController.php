<?php

namespace Modules\Type\Http\Controllers\Dashboard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Type\Entities\Type;
use Modules\Type\Http\Requests\TypeRequest;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $types = Type::orderBy('created_at', 'desc')->paginate(10)
            ->through(function ($query) {
                $returns = [
                    'id' => $query->id,
                    'name' => $query->name,
                    'created_at' => $query->created_at->format('d-m-Y'),
                ];
                $btn = '<div class="d-flex">';
                $btn .= '<a href="javascript:;" class="btn btn-primary me-1 mb-2 btn-modal-view" data-url="' . route('admin.type.edit', ['type' => $returns['id']]) . '"><i class="ti ti-edit" style="margin-right:5px;"></i> Edit</a>';
                $btn .= '<a href="javascript:;" class="btn btn-danger me-1 mb-2 delete-btn" data-url="' . route('admin.type.destroy', ['type' => $returns['id']]) . '"><i class="ti ti-trash" style="margin-right:5px;"></i> Delete</a>';
                $btn .= '</div>';
                $returns['btn'] = $btn;
                return $returns;
            });

        return view('type::type.index', compact('types'));

    }

    /**
     * Store a newly created resource in storage.
     * @param TypeRequest $request
     * @return Renderable
     */
    public function store(TypeRequest $request)
    {
        try {
            $data = [
                'name' => $request->name,
            ];
            Type::create($data);
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
    public function edit(Type $type)
    {
        return view('type::type.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(TypeRequest $request, Type $type)
    {
        try {
            $data['name'] = $request->name;
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
