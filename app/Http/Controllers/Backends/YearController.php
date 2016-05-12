<?php

namespace App\Http\Controllers\Backends;

use App\Models\Faculty;
use App\Models\Role;
use App\Models\Year;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Request;

class YearController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $years = Year::orderBy('year', 'desc')->get();
        return view('backends.admins.year-index')
            ->with('years', $years);
    }

    public function addForm()
    {
        $year = new Year();

        return view('backends.admins.year-addform')
            ->with('year', $year);
    }

    public function doAdd(Request $request)
    {
        $year = Year::create($request->get('year'));
        $year->save();
        return redirect('/backend/year');
    }
}
