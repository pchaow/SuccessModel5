<?php

namespace App\Http\Controllers;

use App\Http\Soaps\LoginSoap;
use App\Http\Soaps\UserInfoSoap;
use App\Models\Faculty;
use App\Models\Role;
use App\Models\User;
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

    private function getUserInfoFromSoap($username, $password)
    {
        $data = [
            'Login' => [
                'username' => base64_encode($username),
                'password' => base64_encode($password),
                'ProductName' => 'decaffair_student',
            ]
        ];

        $loginSoap = new LoginSoap();
        $result = $loginSoap->call('Login', $data);
        $sid = $result->LoginResult;

        $data2 = [
            'GetStaffInfo' => [
                'sessionID' => $sid
            ]
        ];


        $userInfo = new UserInfoSoap();
        $infoResult = $userInfo->call('GetStaffInfo', $data2)->GetStaffInfoResult;

        return $infoResult;
    }

    private function createUserFromSoap($username, $password)
    {

        $infoResult = $this->getUserInfoFromSoap($username, $password);

        $user = new User();
        $user->username = $username;
        $user->title = $infoResult->Title;
        $user->firstname = $infoResult->FirstName_TH;
        $user->lastname = $infoResult->LastName_TH;
        $user->email = $username . "@up.ac.th";
//        $user->save();

        $faculty = Faculty::where('name_th', '=', $infoResult->Faculty)->first();
		
        if ($faculty) {
            $user->faculty_id = $faculty->id;
        }
		$user->save();
		
        $role = Role::where('key', '=', 'researcher')->first();
        $user->roles()->attach($role->id);
        $user->faculty;
        return $user;
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

                return redirect("/backend/");
            } else {


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

                $errors = new MessageBag(['LOGIN_ERROR' => ['ไม่สามารถติดต่อ server มหาลัยเพื่อตรวจสอบรหัสผ่านได้']]);
                return Redirect::back()->withErrors($errors);

            } else {

                $b = @ldap_bind($ad, $userlocal, $password);
                if (!$b) {

                    $errors = new MessageBag(['LOGIN_ERROR' => ['ไม่สามารถเข้าสู่ระบบได้ กรุณาตรวจสอบอีกครั้ง']]);
                    return Redirect::back()->withErrors($errors);

                } else {
                    //ldap ok
                    $useremail = $username . "@up.ac.th";
                    $user = User::with('roles')->where('email', '=', $useremail)->first();
                    if ($user) {
                        Auth::login($user);
                    } else {
                        $user = $this->createUserFromSoap($username, $password);
                        Auth::login($user);
                    }
                    return redirect('/backend');
                }
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}
