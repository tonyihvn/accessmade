<?php

namespace App\Http\Controllers;

use App\Models\subscriptions;
use App\Models\subscription_plans;
use App\Models\interests;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = subscriptions::get();
        return view('product_subscriptions')->with(['subscriptions'=>$subscriptions]);
    }

    public function UploadTemplate()
    {
        $subscriptions = subscriptions::where('status','New')->get();
        return view('upload-template')->with(['subscriptions'=>$subscriptions]);
    }

    public function generateStoppage()
    {
        $subscriptions = subscriptions::where('status','Stoppage')->get();
        return view('stoppage-template')->with(['subscriptions'=>$subscriptions]);
    }




    public function clientSubs($cid)
    {
        $subscriptions = subscriptions::where('client_id',$cid)->get();
        return view('client_subscriptions')->with(['subscriptions'=>$subscriptions]);
    }

    public function topUp(Request $request)
    {
        $grandTotalAmount = 0;
        $allInterestRates = array();
        $allDuration = array();
        $newProduct = '';
        $interestTable = interests::select('months','percentage')->get();

        $priceGrandTotalAmount = 0;
        $interestToAdd = 0;
        foreach($request->topup as $subid){

            $subscription = subscriptions::find($subid);

            $product_name = $subscription->product->title;

            $newProduct.=$product_name." / ";
            $subsTotalAmount = $subscription->subplan->price;

            // Get Product Price
            //$subsProductPrice = $subscription->product->price;
            // Add to Sum Product Price
            //$priceGrandTotalAmount+=$subsProductPrice;

            $subsTotalPaid = $subscription->payments->sum('amount_paid');

            $subsBal = $subsTotalAmount - $subsTotalPaid;

            // Get Extra Interest
            $durationLeft = $subscription->subplan->duration - $subscription->payments->count();

            if($durationLeft==$subscription->subplan->duration){
                $interestToAdd=0;
            }elseif($durationLeft<=3){
                $interestToAdd = $interestTable->where('months',3)->first()->percentage;
            }elseif($durationLeft<=6){
                $interestToAdd = $interestTable->where('months',6)->first()->percentage;
            }elseif($durationLeft<=9){
                $interestToAdd = $interestTable->where('months',9)->first()->percentage;
            }elseif($durationLeft<=12){
                $interestToAdd = $interestTable->where('months',12)->first()->percentage;
            }elseif($durationLeft<=15){
                $interestToAdd = $interestTable->where('months',15)->first()->percentage;
            }elseif($durationLeft<=18){
                $interestToAdd = $interestTable->where('months',18)->first()->percentage;
            }elseif($durationLeft<=24){
                $interestToAdd = $interestTable->where('months',24)->first()->percentage;
            }

            $grandTotalAmount+=$subsBal;

            $oldInterest = ($grandTotalAmount*$interestToAdd)/100;

            $grandTotalAmount+=($oldInterest*$durationLeft);

            $subsInterest = $subscription->subplan->percentage_increase;
            array_push($allInterestRates, $subsInterest);

            $subsDuration = $subscription->subplan->duration;
            array_push($allDuration, $subsDuration);

            $subscription->status = 'Merged';
            $subscription->save();

        }

        $newInterestRate = max($allInterestRates);
        $newDuration = max($allDuration);

        $newInterest = ($grandTotalAmount*$newInterestRate)/100;

        // $newPrice = $grandTotalAmount+$newInterest;

        $newPrice = $grandTotalAmount;
        $monthly_contribution = ceil(($newPrice)/$newDuration);

        $newSubID = subscription_plans::Create([
            'title'=>$newProduct." N".number_format($newPrice,2)."(".$newDuration.")",
            'price'=>$newPrice,
            'product_id'=>19,
            'duration'=>$newDuration,
            'percentage_increase'=>$newInterestRate,
            'monthly_contribution'=>$monthly_contribution,
            'business_id'=>Auth()->user()->business_id
        ])->id;

        subscriptions::updateOrCreate(['id'=>$request->id],[
            'product_id'=>19,
            'client_id'=>$request->client_id,
            'subscription_plan'=>$newSubID,
            'date_subscribed'=>$request->date_subscribed,
            'status'=>$request->status,
            'business_id'=>Auth()->user()->business_id
        ]);
        $message = 'The Subscriptions was successful toped-Up / Merged! Duration Left: '.$durationLeft;

        return redirect()->back()->with(['message'=>$message]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoresubscriptionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        subscriptions::updateOrCreate(['id'=>$request->id],[
            'product_id'=>$request->product_id,
            'client_id'=>$request->client_id,
            'subscription_plan'=>$request->subscription_plan,
            'date_subscribed'=>$request->date_subscribed,
            'penalties'=>$request->penalties,
            'status'=>$request->status,
            'business_id'=>Auth()->user()->business_id
        ]);
        $message = 'The Subscription was successful!';

        return redirect()->back()->with(['message'=>$message]);

    }

    public function paySubscription(Request $request){

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subscriptions  $subscriptions
     * @return \Illuminate\Http\Response
     */
    public function show(subscriptions $subscriptions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subscriptions  $subscriptions
     * @return \Illuminate\Http\Response
     */
    public function edit(subscriptions $subscriptions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatesubscriptionsRequest  $request
     * @param  \App\Models\subscriptions  $subscriptions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatesubscriptionsRequest $request, subscriptions $subscriptions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subscriptions  $subscriptions
     * @return \Illuminate\Http\Response
     */
    public function destroy($sid){
        subscriptions::find($sid)->delete();
        $message = "The subscription has been deleted";

        return redirect()->back()->with(['message'=>$message]);
      }
}
