<?php

namespace App\Http\Controllers\Backends;

use App\Models\Faculty;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
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
        $user->password = Hash::make($user_form['password']);

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

        $user->faculty_id = $user_form["faculty_id"];

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

    public function apiGetResearcher(Request $request, $keyword = null)
    {
        /* @var Role $researchers */
        $researchers = Role::where("key", "=", "researcher")->first();
        if ($keyword == null) {
            $users = $researchers->users()->get();
        } else {
            $users = User::whereHas("roles", function ($query) {
                $query->where('key', '=', 'researcher');
            })
                ->where("firstname", "LIKE", "%$keyword%")
                ->orWhere("lastname", "LIKE", "%$keyword%")
                ->get();
        }


        return $users;
    }

    public function apiGetResearcherForDropdown(Request $request, $keyword = null)
    {
        $users = $this->apiGetResearcher($request, $keyword);
        foreach ($users as $user) {
            $user->fullname = "$user->title$user->firstname $user->lastname";
        }
        return [
            "success" => true,
            "results" => $users
        ];
    }

    public function changeProfile(){
        $user = Auth::user();

        return view('backends.profile')
            ->with('user',$user);
    }

    public function doChangeProfile(Request $request){
        $user_form = $request->get('user');
        $id = Auth::user()->id;

        $user = User::find($id);
        $user->fill($user_form);

        if ($user->password != $user_form["password"]) {
            $user->password = Hash::make($user_form['password']);
        }
        $user->save();
        return redirect('/backend/profile');
    }

}
