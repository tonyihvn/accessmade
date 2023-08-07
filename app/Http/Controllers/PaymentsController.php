<?php

namespace App\Http\Controllers;

use App\Models\payments;
use App\Models\cpayments;
use App\Models\products;
use App\Models\User;
use App\Models\subscriptions;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = payments::all();
        return view('payments')->with(['payments'=>$payments]);
    }

    public function itemPayments($pid)
    {
        if (Auth()->user()->role == 'Super' || Auth()->user()->role == 'Admin'){

            $payments = payments::where('subscription_id',$pid)->get();
        }else{
            $payments = payments::where('subscription_id',$pid)->where('client_id',Auth()->user()->id)->get();
        }

        $item = subscriptions::where('id',$pid)->first();
        return view('item-payments')->with(['payments'=>$payments,'item'=>$item->subplan->title]);

    }

    public function cTransactions()
    {
        $contributions  = cpayments::all();
        return view('ctransactions')->with(['contributions'=>$contributions ]);

    }

    public function myContributions()
    {
        $contributions  = cpayments::where('client_id',Auth()->user()->id)->get();
        return view('client-transactions')->with(['contributions'=>$contributions ]);

    }

    public function onlinePayment()
    {
        return view('online-payment');

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepaymentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment = payments::Create([
            'client_id'=>$request->client_id,
            'product_id'=>$request->product_id,
            'amount_paid'=>$request->amount,
            'payment_date'=>$request->date_paid,
            'subscription_id'=>$request->subscription_id,
            'business_id'=>Auth()->user()->business_id
        ]);

        $thissubpayments = payments::where('subscription_id',$request->subscription_id)->count();
        $TEXT =  $thissubpayments. " of ".$payment->subscription->subplan->duration;

        if(number_format($thissubpayments) >= $payment->subscription->subplan->duration){
            subscriptions::where('id',$request->subscription_id)->update(['status'=>'Completed']);
        }else{
            subscriptions::where('id',$request->subscription_id)->update(['status'=>'Open']);
        }


        $message = 'The Subscription payment was successful! '.$TEXT;

        return redirect()->back()->with(['message'=>$message]);
    }

    public function paySub(Request $request)
    {
        $payment = cpayments::Create([
            'client_id'=>$request->client_id,
            'amount'=>$request->amount,
            'saving_plan'=>$request->saving_plan,
            'account_head'=>$request->account_head,
            'credit_officer'=>$request->credit_officer,
            'status'=>$request->status,
            'payment_date'=>$request->date_paid,
            'business_id'=>Auth()->user()->business_id
        ]);


        $message = 'The '.$request->account_head.' payment was successful! ';

        return redirect()->back()->with(['message'=>$message]);
    }

    public function addPayments()
    {
        return view('upload-payments');
    }

    public function uploadPayments(Request $request)
    {
            // Excel::import(new UsersImport, $request->file('filename'));
                $nomatch="";
                $duplicates="";
                if ($request->file_name != null ){

                  $file = $request->file('file_name');

                  // File Details
                  $filename = $file->getClientOriginalName();
                  $extension = $file->getClientOriginalExtension();
                  $tempPath = $file->getRealPath();
                  $fileSize = $file->getSize();
                  $mimeType = $file->getMimeType();

                  // Valid File Extensions
                  $valid_extension = array("csv");

                  // 500 in Bytes
                  $maxFileSize = 524288;

                  // Check file extension
                  if(in_array(strtolower($extension),$valid_extension)){

                    // Check file size
                    if($fileSize <= $maxFileSize){

                      // File upload location
                      $location = 'uploads';

                      // Upload file
                      $file->move($location,$filename);

                      // Import CSV to Database
                      // $filepath = public_path($location."/".$filename);
                      $filepath = $location."/".$filename;

                      // Reading file
                      $file = fopen($filepath,"r");

                      $importData_arr = array();
                      $i = 0;

                      while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                         $num = count($filedata);
                         // Skip first row (Remove below comment if you want to skip the first row)
                         if($i == 0){
                            $i++;
                            continue;
                         }
                         for ($c=0; $c < $num; $c++) {
                            $importData_arr[$i][] = $filedata [$c];
                         }
                         $i++;
                      }
                      fclose($file);

                      // Insert to MySQL database
                      foreach($importData_arr as $importData){


                        $client_id = User::select('id')->where('ippis_no',$importData[1])->first();

                        if($client_id->isEmpty()){
                            $nomatch .=$importData[1]." IPPIS No, not Found <br>";
                        }else{
                            $subscription = subscriptions::select('id','product_id')->where('client_id',$client_id->id)->where('status','!=','Merged')->first();


                            if(!$subscription->isEmpty()){
                                $duplicates .='No subscription found for IPPIS NO: '.$importData[1]."<br>";
                            }else{

                                $checkInitial = payments::where('client_id',$client_id->id)->where('month',$request->month)->get();


                                if(!$checkInitial->isEmpty()){
                                    $duplicates .='Duplicate Entry for IPPIS NO: '.$importData[1]." for Month of ".date('F', mktime(0, 0, 0, $request->month, 10))."<br>";
                                }else{
                                    $payment = payments::Create([
                                        'client_id'=>$client_id->id,
                                        'product_id'=>19,
                                        'amount_paid'=>$importData[2],
                                        'payment_date'=>$request->date_paid,
                                        'month'=>$request->month,
                                        'subscription_id'=>$subscription->id,
                                        'remarks'=>$importData[3],
                                        'business_id'=>Auth()->user()->business_id
                                    ]);
                                }

                            }
                        }

                      }

                      $message = 'Import  was Successful.<br>'.$nomatch.$duplicates;
                    }else{
                      $message = 'File too large. File must be less than 2MB.';
                    }

                  }else{
                     $message = 'Invalid File Extension.';
                  }

                }else{
                    $message = 'Please select a file.';
                }

            return redirect()->back()->with('message', $message);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function show(payments $payments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function edit(payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepaymentsRequest  $request
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepaymentsRequest $request, payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\payments  $payments
     * @return \Illuminate\Http\Response
     */

     public function deleteCsub($pid){
        cpayments::find($pid)->delete();
        $message = "The record has been deleted";

        return redirect()->back()->with(['message'=>$message]);
      }

    public function destroy($pid){
        payments::find($pid)->delete();
        $message = "The Payment has been deleted";

        return redirect()->back()->with(['message'=>$message]);
      }
}
