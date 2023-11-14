<?php

namespace Modules\Auth\Http\Controllers\Dashboard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Auth\Entities\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10)
            ->through(function ($query) {
                $returns = [
                    'id' => $query->id,
                    'name' => $query->name,
                    'email' => $query->email,
                    'status' => $query->status == 1 ? 'Activated' : 'Deactivated',
                    'created_at' => $query->created_at->format('d-m-Y'),
                ];
                $btn = '<div class="d-flex justify-content-center align-items-center">';
                $btn = $btn . '<a href="javascript:;" class="btn btn-danger me-1 mb-2 delete-btn" data-url="' . route('admin.user.destroy', ['user' => $returns['id']]) . '"><i class="ti ti-trash" style="margin-right:5px;"></i> Delete </a>';
                if ($returns['status'] == 'Activated') {
                    $btn = $btn . '<a class="btn btn-danger me-1 mb-2" title="Deactivated Account" href="' . route('admin.user.update_status', ['user' => $returns['id']]) . '"><i class="ti ti-minus" style="margin-right:5px;"></i> Deactivated Account</a>';
                } else {
                    $btn = $btn . '<a class="btn btn-success me-1 mb-2" title="Activated Account" href="' . route('admin.user.update_status', ['user' => $returns['id']]) . '"><i class="ti ti-check" style="margin-right:5px;"></i> Activated Account</a>';
                }

                $btn .= '</div>';
                $returns['btn'] = $btn;
                return $returns;
            });

        return view('auth::user.index', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back();
    }
    public function update_status($id)
    {
        $user = User::findOrFail($id);

        if ($user->status == '1') {
            $user->tokens()->delete();
            $user->status = '0';
        } else {
            $user->status = '1';
        }
        $user->save();

        return redirect()->back();
    }
}
