<?php
  
namespace App\Http\Controllers\Frontend\User;
use App\Http\Controllers\Controller;  
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use Auth;  
class PlanController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $plans = Plan::get();
        $subscribed = auth()->user()->subscribed('1');
        if($subscribed){
            $grace = auth()->user()->subscription('1')->onGracePeriod();
            if($grace){
                $dayleft = auth()->user()->subscription('1')->ends_at->format('dS M Y');
                return view("frontend.plans", ['plans' => $plans, 'sub' => $subscribed, 'canceled' => $grace, 'expires' => $dayleft]);
            }


        }
        
 
        
  
        return view("frontend.plans", ['plans' => $plans, 'sub' => $subscribed, 'canceled' => false, 'expires' => false]);
    }  
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function show(Plan $plan, Request $request)
    {
        $intent = auth()->user()->createSetupIntent();
        
        return view("frontend.subscription", compact("plan", "intent"));
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function subscription(Request $request)
    {
        $plan = Plan::find($request->plan);
  
        $subscription = $request->user()->newSubscription($request->plan, $plan->stripe_plan)
                        ->create($request->token);


        if($request->plan === '1'){
            User::where('id', Auth::user()->id)->update(['storage'=>'209715200']);

        } else {
            User::where('id', Auth::user()->id)->update(['storage'=>'6442450944']);


        }
        

        

  
        return view("frontend.subscription_success");
    }


    public function cancel(){
        


        auth()->user()->subscription('1')->cancel();


        return view("frontend.cancel");



    }















}