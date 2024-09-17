<?php

namespace App\Http\Controllers\Patient;

use App\AppointmentWithOffer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Day;
use App\Schedule;
use App\Doctor;
use App\Department;
use App\Leave;
use App\ManageText;
use App\NotificationText;
use Auth;
use Cart;
class AppointmentController extends Controller
{

    public function getAppointment(Request $request){
        $websiteLang=ManageText::all();
        $leave=Leave::where(['doctor_id'=>$request->doctor_id,'date'=>$request->date])->count();
        $html="";
        if($leave ==0){
            $doctor_id=$request->doctor_id;
            $day=date('l',strtotime($request->date));
            $day=Day::where('day',$day)->first();
            $day=$day->id;
            $schedules=Schedule::where(['doctor_id'=>$doctor_id,'day_id'=>$day])->get();
            if($schedules->count() !=0){
                foreach($schedules as $index=> $schedule){
                    $html.='<option value="'.$schedule->id.'">'.strtoupper($schedule->start_time).'-'.strtoupper($schedule->end_time).'</option>';
                }
                return response()->json(['success'=>$html]);
            }else{
                $html="<h4 class='text-danger'>".$websiteLang->where('lang_key','schedule_not_found')->first()->custom_lang."</h4>";
                return response()->json(['error'=>$html]);
            }
        }else{
            $html="<h4 class='text-danger'>.$websiteLang->where('lang_key','doc_not_found')->first()->custom_lang.</h4>";
            return response()->json(['error'=>$html]);
        }
    }

    public function getDepartmentDoctor($id){
        $websiteLang=ManageText::all();
        $doctors=Doctor::where(['department_id'=>$id,'status'=>1])->get();
        $html='<option value="">'.$websiteLang->where('lang_key','select_doc')->first()->custom_lang.'</option>';
        if($doctors){
            foreach($doctors as $doctor){
                $html.='<option value="'.$doctor->id.'">'.ucfirst($doctor->name).'</option>';
            }
        }
        return response()->json($html);
    }


    public function createAppointment(Request $request){
        $doctor_id=$request->doctor_id;
        $department_id=$request->department_id;
        $date=$request->date;
        $schedule_id=$request->schedule_id;

        $schedule=Schedule::find($schedule_id);
        $doctor=Doctor::find($doctor_id);
        $department=Department::find($department_id);

        $data['id']=rand(22,222);// it is mendetory
        $data['name']=$doctor->name;
        $data['qty']=1;
        $data['price']=$doctor->fee;
        $data['weight']=0; // it is mendetory
        $data['options']['doctor_id']=$doctor_id;
        $data['options']['department']=$department->name;
        $data['options']['location']=$doctor->location->location;
        $data['options']['date']=$date;
        $data['options']['time']=$schedule->start_time.'-'.$schedule->end_time;
        $data['options']['schedule_id']=$schedule->id;
        $data['options']['day_id']=$schedule->day_id;
        cart::add($data);


        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','app')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        
        
        
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $eventPhn = '966' . ltrim(auth()->user()->phone, '0');

        $url = 'https://ksa-api.com/api/send_massages';
        $data = array(
            'number' => $eventPhn,
            'body' => 'شكرا علي تواصلكم معنا تم انشاء حساب لدي مجمع النعيم الطبي',
            'url' => 'https://land.wmc-ksa.com/social/public/image/wmc-logo.png',
            'type' => 'image',
            'token' => '72|BaWdbyfQsE34JyUs63MLpkJSExBPsbPkavfl8o5Vab61788a'
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
        
        

        return redirect()->route('patient.payment')->with($notification);
    }

    public function removeAppointment($id){
        Cart::remove($id);
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return back()->with($notification);
    }

    


    public function createAppointmentWithOffer(Request $request){
        $data=$request->all();
        AppointmentWithOffer::create($data);
        
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','app')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        
        
        
        
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $eventPhn = '966' . ltrim($request->phone, '0');

        $url = 'https://ksa-api.com/api/send_massages';
        $data = array(
            'number' => $eventPhn,
            'body' => 'شكرا علي تواصلكم معنا تم انشاء حساب لدي مجمع النعيم الطبي',
            'url' => 'https://land.wmc-ksa.com/social/public/image/wmc-logo.png',
            'type' => 'image',
            'token' => '72|BaWdbyfQsE34JyUs63MLpkJSExBPsbPkavfl8o5Vab61788a'
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
        
        

        return redirect()->back()->with($notification);
    }


}
