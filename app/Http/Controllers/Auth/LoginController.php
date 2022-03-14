<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use SoapClient;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo   = RouteServiceProvider::HOME;
    protected $url          = 'dashboard/';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $req)
    {
        // dd($req);
        $user = $req->email;
        $pass = $req->password;

        // cek
        try {
            $cek    = User::where('username', $req->email)->first();
            //dd($cek->getRoleNames());
            $role   = $cek->getRoleNames()[0];
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => 'Password Invalid / Inactive Users']);
        }

        // login
        if ($role == 'USER-DASHBOARD') {
            $ldap = $this->verifyToLdap($req->email, $req->password);
            if ($ldap["responcode"] == "00") {
                return $this->getUserLog($req->email, "P@ssw0rd");
            } else {
                $msg = "LDAP " . $ldap['des'];
                $notification = toaster($msg, 'error', 'Oops!');
                return redirect()->back()->with($notification);
            }
        } else {
            return $this->getUserLog($req->email, $req->password);
        }

        // $msg = 'Invalid Username / Password';
    }

    // Login
    public function showLoginForm()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('/auth/login', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function getUserLog($user, $pass)
    {
        // cek jika yang di input email
        if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
            if (auth()->attempt(['email' => $user, 'password' => $pass])) {

                $title  = '👋 Welcome ' . ucwords(auth()->user()->name) . '!';
                $msg    = welcome_word();
                $notification = toaster($msg, 'success', $title);
                return redirect()->to($this->url)->with($notification);
            }
        } else {
            if (auth()->attempt(['username' => $user, 'password' => $pass])) {

                $title  = '👋 Welcome ' . ucwords(auth()->user()->name) . '!';
                $msg    = welcome_word();
                $notification = toaster($msg, 'success', $title);
                // dd($this->url);
                return redirect()->to($this->url)->with($notification);
            }
        }
    }

    public function verifyToLdap($uname, $encriptloginpass)
    {
        try {
            $client = new SoapClient("http://10.14.18.159:8080/middleware/services/ServicePortTypeBndPortServiceLdap?wsdl");
        } catch (Exception $e) {
            $msg = "Error Connection LDAP";
        }
        //echo
        $data = array();

        $requestItems1 = array(
            "Request" => "cn=$uname , o=megauser"
        );

        $requestItems2 = array(
            "Request" => encryptPass($encriptloginpass)
        );

        $request = array(
            "item" => array($requestItems1, $requestItems2)
        );

        $params = array(
            "ServiceName" => "SERVICE_VERIFY",
            "ClientId" => "47715538-aff8-4fc6-a8e4-ccf9531bbe28",
            "Signature" => "Z2V2nmgXawzm+14H7lkbwzVbJds6QSJPo6QIQrwQXZo=",
            "ArrRequest" => $request
        );

        $response = $client->__soapCall("getServiceLdap", array($params));

        $ResponseCode           = $response->ResponseCode;
        $ResponseDescription    = $response->ResponseDescription;

        return array('responcode' => $ResponseCode, 'des' => $ResponseDescription);
    }
}
