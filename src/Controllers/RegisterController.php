<?php

namespace Knowfox\Passwordless\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Knowfox\Passwordless\Jobs\SendRegisterMail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $theme = config('passwordless.theme');
        return view('passwordless::' . $theme . '.register');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => [
                'required',
                'max:255',
                'regex:/^[-\w\s,\.]+$/u',
            ],
            'email' => 'required|email|max:255|unique:users',
        ], [
            'name.required' => 'Please give us your name',
            'name.regex' => 'Only letters, digits, blanks, dashes, commas, or dots are allowed',
            'email.required' => 'We need your email address for login',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $this->dispatch(new SendRegisterMail($user));

        return $user;
    }

    /**
     * @todo Adapt from Erinnertes
     * @param $what
     * @param $email
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($what, $email)
    {
        $user = User::where('email', $email)->firstOrFail();

        if ($what == 'all') {
            $user->email_upcoming = 0;
            $user->email_comment = 0;
            $user->email_story = 0;
            $user->email_recipient = 0;
            $user->email_newsletter = 0;
            $user->email_promo = 0;
            $user->save();

            return redirect()->back()
                ->with('message', "Du erhälst keine E-Mails mehr von uns");
        }
        else {
            if (in_array($what, [
                'upcoming',
                'comment',
                'story',
                'recipient',
                'newsletter',
                'promo'
            ])) {
                $field = 'email_' . $what;
                $user->{$field} = 0;
                $user->save();

                return redirect()->back()
                    ->with('message', "Du erhälst keine E-Mails zu ' 
                    . ucfirst($what) . ' mehr von uns");
            }
            else {
                return redirect()->back()
                    ->with('message', 'Zu diesem Thema versenden wir keine E-Mails');
            }
        }
    }
}
