<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\projects;
use App\Models\categories;
use App\Models\subscriptions;

// To be used for registration
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth()->user()->role=="Super" || Auth()->user()->role=="Admin"){
            $subscriptions = subscriptions::all();
            return view('home')->with(['subscriptions'=>$subscriptions]);
        }elseif(Auth()->user()->role=="Client"){
            return redirect()->route('products');
        }elseif(Auth()->user()->role=="Contributor"){
            return redirect()->route('my-contributions');
        }

    }

    public function clients()
    {
        $allclients = User::where('role','Client')->get();
        return view('clients')->with(['allclients'=>$allclients]);
    }

    public function Staff()
    {
        $allclients = User::where('category','Staff')->get();
        return view('staff')->with(['allclients'=>$allclients]);
    }

    public function Contributors()
    {
        $allclients = User::where('role','Contributor')->get();
        return view('contributors')->with(['allclients'=>$allclients,'object'=>'Contributors']);
    }

    public function newClient()
    {
        $categories = categories::where('group_name','Clients')->get();
        return view('new-client')->with(['categories'=>$categories,'object'=>'Client']);
    }

    public function newStaff()
    {
        $categories = categories::where('group_name','Staff')->get();
        return view('new-client')->with(['categories'=>$categories,'object'=>'Staff']);
    }

    public function newContributor()
    {
        $categories = categories::where('group_name','Contributors')->get();
        return view('new-client')->with(['categories'=>$categories,'object'=>'Contributors']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function saveClient(Request $request)
    {
        if($request->password!=""){
            $password = Hash::make($request->password);

        }else{
            $password =$request->oldpassword;
        }

        if($request->cid>0){
            $outcome = "modified";
        }else{
            $outcome = "created";
        }

        if($request->email==""){
            $email=str_replace(' ', '', str_replace(',', '', $request->name))."@accessmadelimited.com";
        }else{
            $email = $request->email;
        }

        User::updateOrCreate(['id'=>$request->cid],[
            'name'=>$request->name,
            'email'=>$email,
            'password'=>Hash::make($request->password),
            'about'=>$request->about,
            'phone_number'=>$request->phone_number,
            'company_name'=>$request->company_name,

            'service_no'=>$request->service_no,
            'ippis_no'=>$request->ippis_no,
            'grade_level'=>$request->grade_level,
            'step'=>$request->step,
            'rank'=>$request->rank,
            'service_length'=>$request->service_length,
            'retirement_date'=>$request->retirement_date,
            'salary_account'=>$request->salary_account,
            'bank'=>$request->bank,
            'lga'=>$request->lga,
            'kin_name'=>$request->kin_name,
            'kin_address'=>$request->kin_address,
            'dob'=>$request->dob,

            'category'=>$request->category,
            'address'=>$request->address,
            'role'=>$request->role,
            'status'=>$request->status,
            'business_id'=>Auth()->user()->business_id,



        ]);

        $message = 'The '.$request->object.' has been '.$outcome.' successfully';

        return redirect()->back()->with(['message'=>$message]);
    }

    public function editClient($cid)
    {
        if (Auth()->user()->role == 'Admin' || Auth()->user()->role == 'Super' ) {
            $client = User::where('id',$cid)->first();
        }else{
            $client = User::where('id',Auth()->user()->id)->first();
        }
        $object = $client->role;


        if ($object != 'Client' && $object !='Staff' ) {
            $object = 'Contributors';
        }

        $categories = categories::where('group_name',$object)->get();
        return view('new-client')->with(['client'=>$client,'categories'=>$categories,'object'=>$object]);
    }

    public function settings(request $request){
        $validateData = $request->validate([
            'logo'=>'image|mimes:jpg,png,jpeg,gif,svg',
            'background'=>'image|mimes:jpg,png,jpeg,gif,svg'
        ]);

        if(!empty($request->file('logo'))){

            $logo = time().'.'.$request->logo->extension();

            $request->logo->move(\public_path('images'),$logo);
        }else{
            $logo = $request->oldlogo;
        }

        if(!empty($request->file('background'))){

            $background = time().'.'.$request->background->extension();

            $request->background->move(\public_path('images'),$background);
        }else{
            $background = $request->oldbackground;
        }


        settings::updateOrCreate(['id'=>$request->id],[
            'ministry_name' => $request->ministry_name,
            'motto' => $request->motto,
            'logo' => $logo,
            'address' => $request->address,
            'background' => $background,
            'mode'=>$request->mode,
            'color'=>$request->color,
            'ministrygroup_id'=>$request->ministrygroup_id,
            'user_id'=>$request->user_id
        ]);


        $message = "The settings has been updated!";
        return redirect()->back()->with(['message'=>$message]);
      }

      public function destroy($cid){
        User::find($cid)->delete();
        $message = "The User has been deleted";

        return redirect()->back()->with(['message'=>$message]);
      }

      public function Artisan1($command) {
        $artisan = \Artisan::call($command);
        $output = \Artisan::output();
        return dd($output);
    }

    public function Artisan2($command, $param) {
        $output = \Artisan::call($command.":".$param);
        return dd($output);
    }
    }
