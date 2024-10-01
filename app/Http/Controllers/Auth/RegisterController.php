<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\UserVerification;
use Str;
use Mail;
use App\Rules\Captcha;
use App\Setting;
use App\BannerImage;
use App\Navigation;
use App\ManageText;
use App\EmailTemplate;
use App\ValidationText;
use App\NotificationText;
use App\Helpers\MailHelper;

class RegisterController extends Controller
{


    use RegistersUsers;


    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest:web');
    }


    public function userRegisterPage(){
        $setting=Setting::first();
        $banner=BannerImage::first();
        $navigation=Navigation::first();
        $websiteLang=ManageText::all();
        return view('patient.profile.auth.register')->with(['setting'=>$setting,'banner'=>$banner,'navigation'=>$navigation,'websiteLang'=>$websiteLang]);
    }

    public function storeRegister(Request $request){
            // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            'name'=>'required',
            'phone'=>'required|min:9|numeric',
            'email'=>'required|unique:users|email',
            'password'=>'required|min:3',
            'g-recaptcha-response'=>new Captcha()
        ];

        $customMessages = [
            'name.required' => $valid_lang->where('lang_key','name')->first()->custom_lang,
            'phone.required' => $valid_lang->where('lang_key','phone')->first()->custom_lang,
            'phone.numeric' => $valid_lang->where('lang_key','phone')->first()->custom_lang,
            'email.required' => $valid_lang->where('lang_key','email')->first()->custom_lang,
            'email.unique' => $valid_lang->where('lang_key','unique_email')->first()->custom_lang,
            'password.required' => $valid_lang->where('lang_key','pass')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);

        $user=User::create([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'patient_id'=>date('ymdis'),
            'email_verified_token'=>Str::random(100)
        ]);

        $template=EmailTemplate::where('id',5)->first();
        $message=$template->description;
        $subject=$template->subject;
        $message=str_replace('{{user_name}}',$user->name,$message);
        MailHelper::setMailConfig();
        Mail::to($user->email)->send(new UserVerification($user,$message,$subject));

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','register')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        
        
        
        
        
        
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $eventPhn = '966' . ltrim($request->input('phone'), '0');

        $url = 'https://ksa-api.com/api/send_massages';
        $data = array(
            'number' => $eventPhn,
            'body' => 'شكرا علي تواصلكم معنا تم انشاء حساب لدي مجمع النعيم الطبي',
            'url' => 'https://alnaim.ksa-api.com/uploads/website-images/logo-2024-09-08-01-58-52-4632.png',
            'type' => 'image',
            'token' => '80|J20wwT6JMTxXjoqnswUE3BPV5hL3Q6SHfq3Z2SXi0fd80aed'
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);


        

        return Redirect()->back()->with($notification);
    }

    public function userVerify($token){
        $user=User::where('email_verified_token',$token)->first();
        $notify=NotificationText::first();
        if($user){
            $user->email_verified_token=null;
            $user->status=1;
            $user->email_verified=1;
            $user->save();
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','verify')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');
            return  redirect()->route('login')->with($notification);
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','invalid_token')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('register')->with($notification);
        }
    }
}
