<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class BackendController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('backends.index');
    }

    public function login(Request $request)
    {
        return view('backends.login');
    }

    public function doLogin(Request $request)
    {
        Auth::logout();

        $user = $request->get('user');

        $email = $user['email'];
        $password = $user['password'];
        if (Str::contains($email, '@')) {

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::user();
                $user->roles;
                //return $user;
                return redirect("/backend/");
            } else {
//                return \Response::json([
//                    "error" => "E-mail or Password is invalid"
//                ], 500);

                $errors = new MessageBag(['LOGIN_ERROR' => ['E-mail or Password is invalid.']]);

                return Redirect::back()->withErrors($errors);

            }
        } else {
            $username = $email;
            $password = $password;

            $server = "dcup-01.up.local";
            //dc1-nu
            $userlocal = $username . "@up.local";

            // connect to active directory
            $ad = ldap_connect($server);
            if (!$ad) {
                return \Response::json([
                    "error" => "ไม่สามารถติดต่อ server มหาลัยเพื่อตรวจสอบรหัสผ่านได้"
                ], 500);
            } else {

                $b = @ldap_bind($ad, $userlocal, $password);
                if (!$b) {
                    return \Response::json([
                        "error" => "ไม่สามารถเข้าสู่ระบบได้ กรุณาตรวจสอบอีกครั้ง"
                    ], 500);

                } else {
                    //ldap ok
                    $useremail = $username . "@up.ac.th";
                    $user = User::with('roles')->where('email', '=', $useremail)->first();
                    if ($user) {
                        Auth::login($user);
                    } else {
                        $user = $this->userService->createUserFromSoap($username, $password);
                        Auth::login($user);
                    }
                    return redirect('/backend');
                }
            }
        }

    }

}
