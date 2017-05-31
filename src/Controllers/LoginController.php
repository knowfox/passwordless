<?php

namespace Knowfox\Passwordless\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Knowfox\Passwordless\Models\EmailLogin;
use Knowfox\Passwordless\Jobs\SendLoginMail;


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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('passwordless::login');
    }

    public function login(Request $request)
    {
        $this->validate($request, ['email' => 'required|email|exists:users']);

        $email_login = EmailLogin::createForEmail($request->input('email'));
        $user = $email_login->user()->first();

        $url = route('auth.email-authenticate', [
            'token' => $email_login->token
        ]);

        $this->dispatch(new SendLoginMail($user, $url));

        // show the users a view saying "check your email"
        return redirect('/')
            ->with('status', 'We have sent you an email. It contains a link for you to login.');
    }

    public function authenticateEmail($token)
    {
        $emailLogin = EmailLogin::validFromToken($token);

        Auth::login($emailLogin->user, /*remember*/true);
        return redirect()->route('home');
    }
}
