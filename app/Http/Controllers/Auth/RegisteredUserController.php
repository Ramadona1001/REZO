<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\NOC;
use App\Models\Plan;
use App\Models\PlanRequest;
use App\Models\User;
use  App\Models\Utility;
use Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function create()
    {
        // return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //ReCpatcha
        $settings = Utility::settings();
        //ReCpatcha
        if (isset($settings['recaptcha_module']) && $settings['recaptcha_module'] == 'on') {
            $validation['g-recaptcha-response'] = 'required|captcha';
        } else {
            $validation = [];
        }
        $this->validate($request, $validation);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required', 'string',
                'min:8', 'confirmed', Rules\Password::defaults()
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'company',
            'default_pipeline' => 1,
            'requested_plan' => ($request->plan_id) ? $request->plan_id : 1,
            'plan' => 1,
            'lang' => Utility::getValByName('default_language'),
            'avatar' => '',
            'created_by' => 1,
        ]);

        if (isset($request->plan_id)) {
            PlanRequest::create([
                'user_id' =>$user->id,
                'plan_id' =>$request->plan_id,
                'duration' =>'monthly'
            ]);
        }
        

        Auth::login($user);

        $settings = Utility::settings();

        if ($settings['email_verification'] == 'on') {
            try {


                Utility::smtpDetail(1);

                event(new Registered($user));
                $role_r = Role::findByName('company');
                $user->assignRole($role_r);
                $user->userDefaultDataRegister($user->id);
                $user->userWarehouseRegister($user->id);

                //default bank account for new company
                $user->userDefaultBankAccount($user->id);

                Utility::chartOfAccountTypeData($user->id);
                // Utility::chartOfAccountData($user);
                // default chart of account for new company
                Utility::chartOfAccountData1($user->id);

                Utility::pipeline_lead_deal_Stage($user->id);
                Utility::project_task_stages($user->id);
                Utility::labels($user->id);
                Utility::sources($user->id);
                Utility::jobStage($user->id);
                GenerateOfferLetter::defaultOfferLetterRegister($user->id);
                ExperienceCertificate::defaultExpCertificatRegister($user->id);
                JoiningLetter::defaultJoiningLetterRegister($user->id);
                NOC::defaultNocCertificateRegister($user->id);
            } catch (\Exception $e) {

                $user->delete();
                return redirect()->back()->with('status', __('Email SMTP settings does not configure so please contact to your site admin.'));
            }
            return redirect(RouteServiceProvider::HOME);
        } else {
            $user->email_verified_at = date('h:i:s');
            $user->save();
            $role_r = Role::findByName('company');
            $user->assignRole($role_r);
            $user->userDefaultData($user->id);
            $user->userDefaultDataRegister($user->id);
            //default bank account for new company
            $user->userDefaultBankAccount($user->id);

            Utility::chartOfAccountTypeData($user->id);
            // Utility::chartOfAccountData($user);
            // default chart of account for new company
            Utility::chartOfAccountData1($user->id);

            GenerateOfferLetter::defaultOfferLetterRegister($user->id);
            ExperienceCertificate::defaultExpCertificatRegister($user->id);
            JoiningLetter::defaultJoiningLetterRegister($user->id);
            NOC::defaultNocCertificateRegister($user->id);

            $userArr = [
                'email' => $user->email,
                'password' => $user->password,
            ];

            $resp = Utility::sendUserEmailTemplate('new_user', [$user->id => $user->email], $userArr);

            return redirect(RouteServiceProvider::HOME);
        }
    }

    public function showRegistrationForm($lang = '', $plan = null)
    {

        $settings = Utility::settings();

        if ($settings['enable_signup'] == 'on') {
            $langList = Utility::languages()->toArray();
            $lang = array_key_exists($lang, $langList) ? $lang : 'en';

            if ($lang == '') {
                $lang = Utility::getValByName('default_language');
            }
            \App::setLocale($lang);

            if ($plan != null) {
                $get_plan = Plan::find($plan);
            } else {
                $get_plan = null;
            }

            return view('auth.register', compact('lang', 'get_plan'));
        } else {
            return \Redirect::to('login');
        }
    }
}
