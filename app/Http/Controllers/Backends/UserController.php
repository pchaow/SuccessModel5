<?php

namespace App\Http\Controllers\Backends;

use App\Models\Faculty;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;

class UserController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $users = User::all();
        return view('backends.admins.user-index')
            ->with('users', $users);
    }

    public function addForm()
    {
        $user = new User();

        return view('backends.admins.user-addform')
            ->with('user', $user);
    }

    public function doAdd(Request $request)
    {
        $user_form = $request->get('user');
        $user = new User();
        $user->fill($user_form);
        $user->password = Hash::make($user->password);

        $user->faculty_id = $user_form["faculty_id"];
        $user->save();

        $user->roles()->sync($user_form["role_ids"]);

        return redirect('/backend/user');
    }

    public function editForm($id)
    {
        /* @var User $user */
        $user = User::find($id);

        return view('backends.admins.user-editform')
            ->with('user', $user);
    }

    public function doEdit(Request $request, $id)
    {

        $user_form = $request->get('user');

        $user = User::find($id);
        $user->fill($user_form);

        if ($user->password != $user_form["password"]) {
            $user->password = Hash::make($user_form['password']);
        }
        $user->save();

        $user->roles()->sync($user_form["role_ids"]);


        return redirect('/backend/user');
    }

    public function doDelete($id)
    {
        User::find($id)->delete();
        return redirect('/backend/user');
    }


}
