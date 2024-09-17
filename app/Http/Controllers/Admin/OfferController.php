<?php
namespace App\Http\Controllers\Admin;

use App\Doctor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Department;
use App\Location;
use App\Mail\DoctorLoginInformation;
use Mail;
use Image;
use File;
use Str;
use Hash;
use App\Setting;
use App\EmailTemplate;
use App\Schedule;
use App\Message;
use App\Appointment;
use App\Helpers\MailHelper;
use App\MeetingHistory;
use App\ZoomMeeting;
use App\ZoomCredential;

use App\ManageText;
use App\ValidationText;
use App\NotificationText;
use App\Offer;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers=Offer::all();
        $websiteLang=ManageText::all();
        return view('admin.offers.index',compact('offers','websiteLang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $websiteLang=ManageText::all();
        return view('admin.offers.create',compact('websiteLang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         // project demo mode check
         if(env('PROJECT_MODE')==0){
            $notification=array(
            'messege'=>env('NOTIFY_TEXT'),
            'alert-type'=>'error'
            );

        return redirect()->back()->with($notification);
        }
        // end


        $valid_lang=ValidationText::all();
        $rules = [
            'name'=>'required',
            'image'=>'required',
            'status'=>'required',
        ];

        $customMessages = [
            
            'name.required' => $valid_lang->where('lang_key','name')->first()->custom_lang,
            'image.required' => $valid_lang->where('lang_key','img')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);


        $image=$request->image;
        $extention=$image->getClientOriginalExtension();
        $name= 'offer-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
        $image_path='uploads/custom-images/'.$name;

        Image::make($image)
                ->resize(500,null,function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path($image_path));
        $offer=Offer::create([
                'name'=>$request->name,
                'image'=>$image_path,
                'status'=>$request->status,
            ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.offers.index')->with($notification);
    }


    public function edit(Offer $offer)
    {
        $websiteLang=ManageText::all();
        return view('admin.offers.edit',compact('offer','websiteLang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {

         // project demo mode check
         if(env('PROJECT_MODE')==0){
            $notification=array(
            'messege'=>env('NOTIFY_TEXT'),
            'alert-type'=>'error'
            );

        return redirect()->back()->with($notification);
        }
        // end


        $valid_lang=ValidationText::all();
        $rules = [
            'name'=>'required',
            'image'=>'required',
            'status'=>'required',
        ];

        $customMessages = [
            'image.required' => $valid_lang->where('lang_key','img')->first()->custom_lang,
            'name.required' => $valid_lang->where('lang_key','name')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);

        // upload new image
        $image_path=$offer->image;
        if($request->image){
            $old_image=$offer->image;
            $image=$request->image;
            $extention=$image->getClientOriginalExtension();
            $name= 'offer-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_path='uploads/custom-images/'.$name;
            Image::make($image)
                    ->resize(500,null,function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path($image_path));


            if(File::exists(public_path($old_image)))unlink(public_path($old_image));
        }

        Offer::where('id',$offer->id)->update([
            
            'name'=>$request->name,
            'image'=>$image_path,
            'status'=>$request->status,
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.offers.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {

         // project demo mode check
         if(env('PROJECT_MODE')==0){
            $notification=array(
            'messege'=>env('NOTIFY_TEXT'),
            'alert-type'=>'error'
            );

        return redirect()->back()->with($notification);
        }
        // end
        $old_image=$offer->image;
        
        $offer->delete();
        if(File::exists(public_path($old_image)))unlink(public_path($old_image));
        
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.offers.index')->with($notification);
    }

     // change doctor status
     public function changeStatus($id){
        $offer=Offer::find($id);
        if($offer->status==1){
            $offer->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $offer->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $offer->save();
        return response()->json($message);

    }
}
