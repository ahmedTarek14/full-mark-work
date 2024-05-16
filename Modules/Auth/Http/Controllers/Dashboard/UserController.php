<?php

namespace Modules\Auth\Http\Controllers\Dashboard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Entities\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $users = User::query()->orderBy('id', 'desc')->paginate(10);

            if ($request->ajax()) {
                $sort_by = $request->get('sortby');
                $sort_type = $request->get('sorttype');
                $query = str_replace(" ", "%", $request->get('query'));
                $users = User::query()->where(function($item) use ($query){
                    $item->where('name' , 'LIKE' , '%'.$query.'%')->orWhere('email' , 'LIKE' , '%'.$query.'%');
                })->orderBy($sort_by, $sort_type)->paginate(10);
                
                return view('auth::user.data_table', compact('users'))->render();
            }

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