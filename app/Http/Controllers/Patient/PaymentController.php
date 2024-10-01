<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use Session;
use Stripe;
use App\Day;
use App\Schedule;
use App\Doctor;
use App\Department;
use App\Appointment;
use App\PaymentAccount;
use Auth;
use App\Order;
use Str;
use App\Setting;
use App\BannerImage;
use App\ManageText;
use App\Navigation;
use App\Mail\OrderConfirmation;
use Mail;
use App\EmailTemplate;
use App\NotificationText;
use App\Helpers\MailHelper;
use App\Razorpay;
use App\Flutterwave;
use Razorpay\Api\Api;
use Exception;

use App\PaystackAndMollie;
use App\InstamojoPayment;
use App\PaymongoPayment;
use Redirect;
use Mollie\Laravel\Facades\Mollie;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function payment(){
        
        $currency=Setting::first();
        $user=Auth::guard('web')->user();
        $notify=NotificationText::first();
        if($user->ready_for_appointment==1){
            $appointments=Cart::content();
            $stripe=PaymentAccount::first();
            $banner=BannerImage::first();
            $navigation=Navigation::first();
            $websiteLang=ManageText::all();
            $razorpay=Razorpay::first();
            $paymentSetting=$stripe;
            $flutterwave = Flutterwave::first();
            $setting = Setting::first();

            $paymentSetting=$stripe;
            $paystack = PaystackAndMollie::first();
            $instamojo = InstamojoPayment::first();
            $paymongo = PaymongoPayment::first();
            $mollie = $paystack;
            return view('patient.profile.payment',compact('appointments','stripe','currency','banner','navigation','websiteLang','razorpay','paymentSetting','user','flutterwave','setting','paystack','instamojo','mollie', 'paymongo'));
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','fill_up')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('patient.account')->with($notification);
        };

    }


    public function stripePayment(Request $request){
            // project demo mode check
    if(env('PROJECT_MODE')==0){
        $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
        return redirect()->back()->with($notification);
    }
    // end

        $user=Auth::guard('web')->user();
        $stripe=PaymentAccount::first();
        $currency=Setting::first();
        $setting = $currency;
        $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());
        $amount_usd = round($cartPrice / $setting->currency_rate,2);
        $payableAmount = round($cartPrice * $stripe->stripe_currency_rate,2);
        Stripe\Stripe::setApiKey($stripe->stripe_secret);
        $result=Stripe\Charge::create ([
                "amount" => $payableAmount * 100,
                "currency" => $stripe->stripe_currency_code,
                "source" => $request->stripeToken,
                "description" => "Doctor appointment"
        ]);

        // insert order
        $order= Order::create([
            'user_id'=>$user->id,
            'order_id'=>'#'.date('Yms').rand(9,99),
            'total_payment'=>str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal()),
            'appointment_qty'=>Cart::count(),
            'payment_method'=>'Stripe',
            'payment_status'=>1,
            'last4'=>substr($request->card_digit,-4),
            'payment_transaction_id'=>$result->balance_transaction
        ]);
        $order_details="";
        foreach(Cart::content() as $item){
            Appointment::create([
                'order_id'=>$order->id,
                'doctor_id'=>$item->options->doctor_id,
                'user_id'=>$user->id,
                'day_id'=>$item->options->day_id,
                'schedule_id'=>$item->options->schedule_id,
                'date'=>$item->options->date,
                'appointment_fee'=>$item->price,
                'payment_status'=>1,
                'payment_transaction_id'=>$result->balance_transaction,
                'payment_method'=>'Stripe',

            ]);

            $doctor=Doctor::find($item->options->doctor_id);
            $order_details.='Doctor: '. $doctor->name. '<br>';
            $order_details.='Phone: '. $doctor->phone .'<br>';
            $order_details.='Schedule: '.$item->options->time .'<br>';
            $order_details.='Date: '.$currency->currency_icon.$item->price .'<br>';
        }

        Cart::destroy();

         // send email
         $template=EmailTemplate::where('id',6)->first();
         $message=$template->description;
         $subject=$template->subject;
         $message=str_replace('{{patient_name}}',$user->name,$message);
         $message=str_replace('{{orderId}}', $order->order_id ,$message);
         $message=str_replace('{{payment_method}}','Stripe',$message);
         $total_amount=$currency->currency_icon. $order->total_payment;
         $message=str_replace('{{amount}}',$total_amount,$message);
         $message=str_replace('{{order_details}}',$order_details,$message);
         MailHelper::setMailConfig();
         Mail::to($user->email)->send(new OrderConfirmation($message,$subject));

         $notify_lang=NotificationText::all();
         $notification=$notify_lang->where('lang_key','payment')->first()->custom_lang;
         $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('patient.order')->with($notification);
    }
    public function bankPayment(Request $request){

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $this->validate($request,[
            'description'=>'required'
        ]);

        $currency=Setting::first();
        $user=Auth::guard('web')->user();

        // insert order
        $order= Order::create([
            'user_id'=>$user->id,
            'order_id'=>'#'.date('Yms').rand(9,99),
            'total_payment'=>str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal()),
            'appointment_qty'=>Cart::count(),
            'payment_method'=>'Bank Transfer',
            'payment_status'=>0,
            'payment_transaction_id'=>null,
            'payment_description'=>$request->description
        ]);

        $order_details="";
        foreach(Cart::content() as $item){
            Appointment::create([
                'order_id'=>$order->id,
                'doctor_id'=>$item->options->doctor_id,
                'user_id'=>$user->id,
                'day_id'=>$item->options->day_id,
                'schedule_id'=>$item->options->schedule_id,
                'date'=>$item->options->date,
                'appointment_fee'=>$item->price,
                'payment_status'=>0,
                'payment_transaction_id'=>null,
                'payment_method'=>'Bank Transfer',
                'payment_description'=>$request->description,
            ]);

            $doctor=Doctor::find($item->options->doctor_id);
            $order_details.='Doctor: '. $doctor->name. '<br>';
            $order_details.='Phone: '. $doctor->phone .'<br>';
            $order_details.='Schedule: '.$item->options->time .'<br>';
            $order_details.='Date: '.$currency->currency_icon.$item->price .'<br>';

        }

        Cart::destroy();

        // send email
        $template=EmailTemplate::where('id',6)->first();
        $message=$template->description;
        $subject=$template->subject;
        $message=str_replace('{{patient_name}}',$user->name,$message);
        $message=str_replace('{{orderId}}', $order->order_id ,$message);
        $message=str_replace('{{payment_method}}','Bank Transfer',$message);
        $total_amount=$currency->currency_icon. $order->total_payment;
        $message=str_replace('{{amount}}',$total_amount,$message);
        $message=str_replace('{{order_details}}',$order_details,$message);
        MailHelper::setMailConfig();
        Mail::to($user->email)->send(new OrderConfirmation($message,$subject));

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','payment')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('patient.order')->with($notification);


    }


    public function razorPay(Request $request){
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $user=Auth::guard('web')->user();
        $stripe=PaymentAccount::first();
        $currency=Setting::first();

        $razorpay=Razorpay::first();
        $input = $request->all();
        $api = new Api($razorpay->razorpay_key,$razorpay->secret_key);
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $payId=$response->id;

                // insert order
                $order= Order::create([
                    'user_id'=>$user->id,
                    'order_id'=>'#'.date('Yms').rand(9,99),
                    'total_payment'=>str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal()),
                    'appointment_qty'=>Cart::count(),
                    'payment_method'=>'RazorPay',
                    'payment_status'=>1,
                    'payment_transaction_id'=>$payId
                ]);
                $order_details="";
                foreach(Cart::content() as $item){
                    Appointment::create([
                        'order_id'=>$order->id,
                        'doctor_id'=>$item->options->doctor_id,
                        'user_id'=>$user->id,
                        'day_id'=>$item->options->day_id,
                        'schedule_id'=>$item->options->schedule_id,
                        'date'=>$item->options->date,
                        'appointment_fee'=>$item->price,
                        'payment_status'=>1,
                        'payment_transaction_id'=>$payId,
                        'payment_method'=>'Razorpay',
                    ]);

                    $doctor=Doctor::find($item->options->doctor_id);
                    $order_details.='Doctor: '. $doctor->name. '<br>';
                    $order_details.='Phone: '. $doctor->phone .'<br>';
                    $order_details.='Schedule: '.$item->options->time .'<br>';
                    $order_details.='Date: '.$currency->currency_icon.$item->price .'<br>';
                }

                Cart::destroy();

                // send email
                $template=EmailTemplate::where('id',6)->first();
                $message=$template->description;
                $subject=$template->subject;
                $message=str_replace('{{patient_name}}',$user->name,$message);
                $message=str_replace('{{orderId}}', $order->order_id ,$message);
                $message=str_replace('{{payment_method}}','Razorpay',$message);
                $total_amount=$currency->currency_icon. $order->total_payment;
                $message=str_replace('{{amount}}',$total_amount,$message);
                $message=str_replace('{{order_details}}',$order_details,$message);
                MailHelper::setMailConfig();
                Mail::to($user->email)->send(new OrderConfirmation($message,$subject));

                $notify_lang=NotificationText::all();
                $notification=$notify_lang->where('lang_key','payment')->first()->custom_lang;
                $notification=array('messege'=>$notification,'alert-type'=>'success');

                return redirect()->route('patient.order')->with($notification);
            }catch (Exception $e) {
                $notify_lang=NotificationText::all();
                $notification=$notify_lang->where('lang_key','payment_faild')->first()->custom_lang;
                $notification=array('messege'=>$notification,'alert-type'=>'error');

                return redirect()->route('patient.payment')->with($notification);
            }
        }
    }

    public function flutterwave(Request $request){
        $flutterwave = Flutterwave::first();
        $curl = curl_init();
        $tnx_id = $request->tnx_id;
        $url = "https://api.flutterwave.com/v3/transactions/$tnx_id/verify";
        $token = $flutterwave->secret_key;
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        if($response->status == 'success'){
            $user=Auth::guard('web')->user();
            $currency=Setting::first();
            // insert order
            $order= Order::create([
                'user_id'=>$user->id,
                'order_id'=>'#'.date('Yms').rand(9,99),
                'total_payment'=>str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal()),
                'appointment_qty'=>Cart::count(),
                'payment_method'=>'Stripe',
                'payment_status'=>1,
                'last4'=>substr($request->card_digit,-4),
                'payment_transaction_id'=>$tnx_id
            ]);
            $order_details="";
            foreach(Cart::content() as $item){
                Appointment::create([
                    'order_id'=>$order->id,
                    'doctor_id'=>$item->options->doctor_id,
                    'user_id'=>$user->id,
                    'day_id'=>$item->options->day_id,
                    'schedule_id'=>$item->options->schedule_id,
                    'date'=>$item->options->date,
                    'appointment_fee'=>$item->price,
                    'payment_status'=>1,
                    'payment_transaction_id'=>$tnx_id,
                    'payment_method'=>'Flutterwave',

                ]);

                $doctor=Doctor::find($item->options->doctor_id);
                $order_details.='Doctor: '. $doctor->name. '<br>';
                $order_details.='Phone: '. $doctor->phone .'<br>';
                $order_details.='Schedule: '.$item->options->time .'<br>';
                $order_details.='Date: '.$currency->currency_icon.$item->price .'<br>';
            }

            Cart::destroy();

            // send email
            $template=EmailTemplate::where('id',6)->first();
            $message=$template->description;
            $subject=$template->subject;
            $message=str_replace('{{patient_name}}',$user->name,$message);
            $message=str_replace('{{orderId}}', $order->order_id ,$message);
            $message=str_replace('{{payment_method}}','Flutterwave',$message);
            $total_amount=$currency->currency_icon. $order->total_payment;
            $message=str_replace('{{amount}}',$total_amount,$message);
            $message=str_replace('{{order_details}}',$order_details,$message);
            MailHelper::setMailConfig();
            Mail::to($user->email)->send(new OrderConfirmation($message,$subject));

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','payment')->first()->custom_lang;
            return response()->json(['status' => 'success' , 'message' => $notification]);
        }else{

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','payment_faild')->first()->custom_lang;
            return response()->json(['status' => 'faild' , 'message' => $notification]);
        }
    }


    public function paystackPayment(Request $request){

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array(
                'messege'=>env('NOTIFY_TEXT'),
                'alert-type'=>'error'
            );

            return redirect()->back()->with($notification);
        }
        // end

        $paystack = PaystackAndMollie::first();

        $reference = $request->reference;
        $transaction = $request->tnx_id;
        $secret_key = $paystack->paystack_secret_key;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST =>0,
            CURLOPT_SSL_VERIFYPEER =>0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $secret_key",
                "Cache-Control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $final_data = json_decode($response);
        if($final_data->status == true) {
            $user=Auth::guard('web')->user();
            $currency=Setting::first();
            // insert order
            $order= Order::create([
                'user_id'=>$user->id,
                'order_id'=>'#'.date('Yms').rand(9,99),
                'total_payment'=>str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal()),
                'appointment_qty'=>Cart::count(),
                'payment_method'=>'Paystack',
                'payment_status'=>1,
                'last4'=>substr($request->card_digit,-4),
                'payment_transaction_id'=>$request->tnx_id
            ]);
            $order_details="";
            foreach(Cart::content() as $item){
                Appointment::create([
                    'order_id'=>$order->id,
                    'doctor_id'=>$item->options->doctor_id,
                    'user_id'=>$user->id,
                    'day_id'=>$item->options->day_id,
                    'schedule_id'=>$item->options->schedule_id,
                    'date'=>$item->options->date,
                    'appointment_fee'=>$item->price,
                    'payment_status'=>1,
                    'payment_transaction_id'=>$request->tnx_id,
                    'payment_method'=>'Paystack',

                ]);

                $doctor=Doctor::find($item->options->doctor_id);
                $order_details.='Doctor: '. $doctor->name. '<br>';
                $order_details.='Phone: '. $doctor->phone .'<br>';
                $order_details.='Schedule: '.$item->options->time .'<br>';
                $order_details.='Date: '.$currency->currency_icon.$item->price .'<br>';
            }

            Cart::destroy();

            // send email
            $template=EmailTemplate::where('id',6)->first();
            $message=$template->description;
            $subject=$template->subject;
            $message=str_replace('{{patient_name}}',$user->name,$message);
            $message=str_replace('{{orderId}}', $order->order_id ,$message);
            $message=str_replace('{{payment_method}}','Paystack',$message);
            $total_amount=$currency->currency_icon. $order->total_payment;
            $message=str_replace('{{amount}}',$total_amount,$message);
            $message=str_replace('{{order_details}}',$order_details,$message);
            MailHelper::setMailConfig();
            Mail::to($user->email)->send(new OrderConfirmation($message,$subject));

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','payment')->first()->custom_lang;
            return response()->json(['status' => 'success' , 'message' => $notification]);

        }
    }


    public function molliePayment(){
        $mollie = PaystackAndMollie::first();
        $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());
        $user=Auth::guard('web')->user();
        $payableAmount = round($cartPrice * $mollie->mollie_currency_rate);
        $payableAmount= number_format($payableAmount, 2);

        $mollie_api_key = $mollie->mollie_key;
        $currency = strtoupper($mollie->mollie_currency_code);
        Mollie::api()->setApiKey($mollie_api_key);
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => $currency,
                'value' => ''.$payableAmount.'',
            ],
            'description' => env('APP_NAME'),
            'redirectUrl' => route('patient.mollie-payment-success'),
        ]);


        $payment = Mollie::api()->payments()->get($payment->id);
        session()->put('payment_id',$payment->id);
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function molliePaymentSuccess(Request $request){
        $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());
        $mollie = PaystackAndMollie::first();
        $mollie_api_key = $mollie->mollie_key;
        Mollie::api()->setApiKey($mollie_api_key);
        $payment = Mollie::api()->payments->get(session()->get('payment_id'));
        if ($payment->isPaid()){
            $payment_id = Session::get('payment_id');
            $user=Auth::guard('web')->user();
            $setting = Setting::first();
            $currency = $setting;

            // insert order
            $order= Order::create([
                'user_id'=>$user->id,
                'order_id'=>'#'.date('Yms').rand(9,99),
                'total_payment'=>str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal()),
                'appointment_qty'=>Cart::count(),
                'payment_method'=>'Mollie',
                'payment_status'=>1,
                'last4'=>substr($request->card_digit,-4),
                'payment_transaction_id'=>$payment_id
            ]);
            $order_details="";
            foreach(Cart::content() as $item){
                Appointment::create([
                    'order_id'=>$order->id,
                    'doctor_id'=>$item->options->doctor_id,
                    'user_id'=>$user->id,
                    'day_id'=>$item->options->day_id,
                    'schedule_id'=>$item->options->schedule_id,
                    'date'=>$item->options->date,
                    'appointment_fee'=>$item->price,
                    'payment_status'=>1,
                    'payment_transaction_id'=>$payment_id,
                    'payment_method'=>'Mollie',

                ]);

                $doctor=Doctor::find($item->options->doctor_id);
                $order_details.='Doctor: '. $doctor->name. '<br>';
                $order_details.='Phone: '. $doctor->phone .'<br>';
                $order_details.='Schedule: '.$item->options->time .'<br>';
                $order_details.='Date: '.$currency->currency_icon.$item->price .'<br>';
            }

            Cart::destroy();

            // send email
            $template=EmailTemplate::where('id',6)->first();
            $message=$template->description;
            $subject=$template->subject;
            $message=str_replace('{{patient_name}}',$user->name,$message);
            $message=str_replace('{{orderId}}', $order->order_id ,$message);
            $message=str_replace('{{payment_method}}','Mollie',$message);
            $total_amount=$currency->currency_icon. $order->total_payment;
            $message=str_replace('{{amount}}',$total_amount,$message);
            $message=str_replace('{{order_details}}',$order_details,$message);
            MailHelper::setMailConfig();
            Mail::to($user->email)->send(new OrderConfirmation($message,$subject));

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','payment')->first()->custom_lang;
            return redirect()->route('patient.order')->with($notification);



        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','something')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->route('patient.payment')->with($notification);
        }
    }

    public function payWithInstamojo(){

        $instamojoPayment = InstamojoPayment::first();
        $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());
        $user=Auth::guard('web')->user();
        $payableAmount = round($cartPrice * $instamojoPayment->currency_rate);
        $setting = Setting::first();
        $price = $payableAmount;
        $environment = $instamojoPayment->account_mode;
        $api_key = $instamojoPayment->api_key;
        $auth_token = $instamojoPayment->auth_token;

        if($environment == 'Sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/';
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url.'payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"));
        $payload = Array(
            'purpose' => env("APP_NAME"),
            'amount' => $price,
            'phone' => '918160651749',
            'buyer_name' => Auth::user()->name,
            'redirect_url' => route('patient.instamojo-response'),
            'send_email' => true,
            'webhook' => 'http://www.example.com/webhook/',
            'send_sms' => true,
            'email' => Auth::user()->email,
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        return redirect($response->payment_request->longurl);
    }

    public function instamojoResponse(Request $request){
        $input = $request->all();

        $instamojoPayment = InstamojoPayment::first();
        $environment = $instamojoPayment->account_mode;
        $api_key = $instamojoPayment->api_key;
        $auth_token = $instamojoPayment->auth_token;

        if($environment == 'Sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.'payments/'.$request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"));
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            $notification = trans('user_validation.Payment Faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('user.checkout.payment')->with($notification);
        } else {
            $data = json_decode($response);
        }

        if($data->success == true) {
            if($data->payment->status == 'Credit') {
                $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());
                $payment_id = Session::get('payment_id');
                $user=Auth::guard('web')->user();
                $setting = Setting::first();
                $currency = $setting;

                // insert order
                $order= Order::create([
                    'user_id'=>$user->id,
                    'order_id'=>'#'.date('Yms').rand(9,99),
                    'total_payment'=>str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal()),
                    'appointment_qty'=>Cart::count(),
                    'payment_method'=>'Instamojo',
                    'payment_status'=>1,
                    'last4'=>substr($request->card_digit,-4),
                    'payment_transaction_id'=>$request->get('payment_id')
                ]);
                $order_details="";
                foreach(Cart::content() as $item){
                    Appointment::create([
                        'order_id'=>$order->id,
                        'doctor_id'=>$item->options->doctor_id,
                        'user_id'=>$user->id,
                        'day_id'=>$item->options->day_id,
                        'schedule_id'=>$item->options->schedule_id,
                        'date'=>$item->options->date,
                        'appointment_fee'=>$item->price,
                        'payment_status'=>1,
                        'payment_transaction_id'=>$request->get('payment_id'),
                        'payment_method'=>'Instamojo',

                    ]);

                    $doctor=Doctor::find($item->options->doctor_id);
                    $order_details.='Doctor: '. $doctor->name. '<br>';
                    $order_details.='Phone: '. $doctor->phone .'<br>';
                    $order_details.='Schedule: '.$item->options->time .'<br>';
                    $order_details.='Date: '.$currency->currency_icon.$item->price .'<br>';
                }

                Cart::destroy();

                // send email
                $template=EmailTemplate::where('id',6)->first();
                $message=$template->description;
                $subject=$template->subject;
                $message=str_replace('{{patient_name}}',$user->name,$message);
                $message=str_replace('{{orderId}}', $order->order_id ,$message);
                $message=str_replace('{{payment_method}}','Instamojo',$message);
                $total_amount=$currency->currency_icon. $order->total_payment;
                $message=str_replace('{{amount}}',$total_amount,$message);
                $message=str_replace('{{order_details}}',$order_details,$message);
                MailHelper::setMailConfig();
                Mail::to($user->email)->send(new OrderConfirmation($message,$subject));

                $notify_lang=NotificationText::all();
                $notification=$notify_lang->where('lang_key','payment')->first()->custom_lang;
                return redirect()->route('patient.order')->with($notification);


            }
        }

    }


    public function payWithPaymongo(Request $request){
       

        $user=Auth::guard('web')->user();
        $currency=Setting::first();
        $setting = $currency;
        $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());

        $total_price = $cartPrice;
        $paymongoPayment = PaymongoPayment::first();
        $price = $total_price * $paymongoPayment->currency_rate;
        $price = round($price);
        $currency_code = $paymongoPayment->currency_code;
        $setting=Setting::first();

        $amount_usd = round($cartPrice / $setting->currency_rate,2);
        $payableAmount = round($cartPrice * $paymongoPayment->currency_rate,2);

                 return view('patient.payment.index',compact('total_price',));

    }


    public function payWithPaymongoGrabPay(){
        $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());
        $user=Auth::guard('web')->user();
        $paymongoPayment = PaymongoPayment::first();
        $total_price = $cartPrice;
        $price = $total_price * $paymongoPayment->currency_rate;
        $price = round($price);
        $success_url = route('patient.paymongo-payment-success');
        $faild_url = route('patient.paymongo-payment-cancled');
        $currency_code = $paymongoPayment->currency_code;

        if($price < 100){
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','amont_100')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->back()->with($notification);
        }

        $price = $price * 100;

        require_once('vendor/autoload.php');
        $code = base64_encode($paymongoPayment->public_key.':'.$paymongoPayment->secret_key);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.paymongo.com/v1/sources', [
        'body' => '{"data":{"attributes":{"amount":'.$price.',"redirect":{"success":"'.$success_url.'","failed":"'.$faild_url.'"},"type":"grab_pay","currency":"'.$currency_code.'"}}}',
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$code.'',
            'Content-Type' => 'application/json',
        ],
        ]);
        $response = json_decode($response->getBody(), true);
        session()->put('payment_id',$response['data']['id']);
        return redirect()->to($response['data']['attributes']['redirect']['checkout_url']);

    }


    public function payWithPaymongoGcash(){
        $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());
        $user=Auth::guard('web')->user();
        $paymongoPayment = PaymongoPayment::first();
        $total_price = $cartPrice;
        $price = $total_price * $paymongoPayment->currency_rate;
        $price = round($price);
        $success_url = route('patient.paymongo-payment-success');
        $faild_url = route('patient.paymongo-payment-cancled');
        $currency_code = $paymongoPayment->currency_code;

        if($price < 100){
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','amont_100')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->back()->with($notification);
        }

        $price = $price * 100;

        require_once('vendor/autoload.php');
        $code = base64_encode($paymongoPayment->public_key.':'.$paymongoPayment->secret_key);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.paymongo.com/v1/sources', [
        'body' => '{"data":{"attributes":{"amount":'.$price.',"redirect":{"success":"'.$success_url.'","failed":"'.$faild_url.'"},"type":"gcash","currency":"'.$currency_code.'"}}}',
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.$code.'',
            'Content-Type' => 'application/json',
        ],
        ]);
        $response = json_decode($response->getBody(), true);
        session()->put('payment_id',$response['data']['id']);
        return redirect()->to($response['data']['attributes']['redirect']['checkout_url']);
    }


    public function paymongoPaymentSuccess(Request $request){
        $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());
        $payment_id = Session::get('payment_id');
        $user=Auth::guard('web')->user();
        $setting = Setting::first();
        $currency = $setting;

        // insert order
        $order= Order::create([
            'user_id'=>$user->id,
            'order_id'=>'#'.date('Yms').rand(9,99),
            'total_payment'=>str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal()),
            'appointment_qty'=>Cart::count(),
            'payment_method'=>'Paymongo',
            'payment_status'=>1,
            'payment_transaction_id'=>$payment_id
        ]);
        $order_details="";
        foreach(Cart::content() as $item){
            Appointment::create([
                'order_id'=>$order->id,
                'doctor_id'=>$item->options->doctor_id,
                'user_id'=>$user->id,
                'day_id'=>$item->options->day_id,
                'schedule_id'=>$item->options->schedule_id,
                'date'=>$item->options->date,
                'appointment_fee'=>$item->price,
                'payment_status'=>1,
                'payment_transaction_id'=>$payment_id,
                'payment_method'=>'Paymongo',

            ]);

            $doctor=Doctor::find($item->options->doctor_id);
            $order_details.='Doctor: '. $doctor->name. '<br>';
            $order_details.='Phone: '. $doctor->phone .'<br>';
            $order_details.='Schedule: '.$item->options->time .'<br>';
            $order_details.='Date: '.$currency->currency_icon.$item->price .'<br>';
        }

        Cart::destroy();

        // send email
        $template=EmailTemplate::where('id',6)->first();
        $message=$template->description;
        $subject=$template->subject;
        $message=str_replace('{{patient_name}}',$user->name,$message);
        $message=str_replace('{{orderId}}', $order->order_id ,$message);
        $message=str_replace('{{payment_method}}','Paymongo',$message);
        $total_amount=$currency->currency_icon. $order->total_payment;
        $message=str_replace('{{amount}}',$total_amount,$message);
        $message=str_replace('{{order_details}}',$order_details,$message);
        MailHelper::setMailConfig();
        Mail::to($user->email)->send(new OrderConfirmation($message,$subject));

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','payment')->first()->custom_lang;
        return redirect()->route('patient.order')->with($notification);
    }


    public function paymongoPaymentCancled(Request $request){
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','payment_faild')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'error');

        return redirect()->route('patient.payment')->with($notification);
    }


}

