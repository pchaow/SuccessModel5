<?php

namespace App\Http\Controllers\Backends;

use App\Models\Faculty;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Request;

class FacultyController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {

        $faculties = Faculty::all();

        return view('backends.admins.faculty-index')
            ->with('faculties', $faculties);
    }


    public function addForm()
    {
        $faculty = new Faculty();

        return view('backends.admins.faculty-addform')
            ->with('faculty', $faculty);
    }

    public function doAdd(Request $request)
    {

        $faculty = Faculty::create($request->get('faculty'));
        $faculty->save();
        return redirect('/backend/faculty');
    }

    public function editForm($id)
    {
        $faculty = Faculty::find($id);

        return view('backends.admins.faculty-editform')
            ->with('faculty', $faculty);
    }

    public function doEdit(Request $request, $id)
    {
        $faculty = Faculty::find($id);
        $faculty->fill($request->get('faculty'));

        return redirect('/backend/faculty');
    }

    public function doDelete($id)
    {
        Faculty::find($id)->delete();
        return redirect('/backend/faculty');
    }

}
