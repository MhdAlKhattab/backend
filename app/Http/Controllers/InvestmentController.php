<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Investment;
use App\Models\Info;
use App\Models\User;
use App\Models\Referral;
use Carbon\Carbon;

class InvestmentController extends Controller
{
    public function getAllInvestments()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $invests = Investment::with('User')->orderBy('created_at','desc')->get();

        foreach($invests as $invest){
            $period = $invest->return_period;
            $invest_time = Carbon::parse($invest->last_update);
            $now = Carbon::now();
            $diff = $invest_time->diffInSeconds($now);

            if($period == 'week' and $diff > 604800){
                $diff = 604799;
            }elseif($period == 'month' and $diff > 2628288){
                $diff = 2628287;
            }elseif($period == '3months' and $diff > 7884864){
                $diff = 7884863;
            }elseif($period == '6months' and $diff > 15778463){
                $diff = 15778462;
            }elseif($period == '12months' and $diff > 31536000){
                $diff = 31535999;
            }
            
            $invest->spending_time = $diff;
            $invest->save();
        }

        return response()->json(['data' => $invests]);
    }


    public function getPenddingInvestments()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $invests = Investment::with('User')->where('state', 0)->orderBy('created_at','desc')->get();

        foreach($invests as $invest){
            $period = $invest->return_period;
            $invest_time = Carbon::parse($invest->last_update);
            $now = Carbon::now();
            $diff = $invest_time->diffInSeconds($now);

            if($period == 'week' and $diff > 604800){
                $diff = 604799;
            }elseif($period == 'month' and $diff > 2628288){
                $diff = 2628287;
            }elseif($period == '3months' and $diff > 7884864){
                $diff = 7884863;
            }elseif($period == '6months' and $diff > 15778463){
                $diff = 15778462;
            }elseif($period == '12months' and $diff > 31536000){
                $diff = 31535999;
            }
            
            $invest->spending_time = $diff;
            $invest->save();
        }

        return response()->json(['data' => $invests]);
    }

    public function getProgressedInvestments()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $invests = Investment::with('User')->where('state', 1)->orderBy('created_at','desc')->get();

        foreach($invests as $invest){
            $period = $invest->return_period;
            $invest_time = Carbon::parse($invest->last_update);
            $now = Carbon::now();
            $diff = $invest_time->diffInSeconds($now);

            if($period == 'week' and $diff > 604800){
                $diff = 604799;
            }elseif($period == 'month' and $diff > 2628288){
                $diff = 2628287;
            }elseif($period == '3months' and $diff > 7884864){
                $diff = 7884863;
            }elseif($period == '6months' and $diff > 15778463){
                $diff = 15778462;
            }elseif($period == '12months' and $diff > 31536000){
                $diff = 31535999;
            }
            
            $invest->spending_time = $diff;
            $invest->save();
        }

        return response()->json(['data' => $invests]);
    }

    public function getCompletedInvestments()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $invests = Investment::with('User')->where('state', 3)->orderBy('created_at','desc')->get();

        foreach($invests as $invest){
            $period = $invest->return_period;
            $invest_time = Carbon::parse($invest->last_update);
            $now = Carbon::now();
            $diff = $invest_time->diffInSeconds($now);

            if($period == 'week' and $diff > 604800){
                $diff = 604799;
            }elseif($period == 'month' and $diff > 2628288){
                $diff = 2628287;
            }elseif($period == '3months' and $diff > 7884864){
                $diff = 7884863;
            }elseif($period == '6months' and $diff > 15778463){
                $diff = 15778462;
            }elseif($period == '12months' and $diff > 31536000){
                $diff = 31535999;
            }
            
            $invest->spending_time = $diff;
            $invest->save();
        }

        return response()->json(['data' => $invests]);
    }

    public function getCanceledInvestments()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $invests = Investment::with('User')->where('state', 2)->orderBy('created_at','desc')->get();

        foreach($invests as $invest){
            $period = $invest->return_period;
            $invest_time = Carbon::parse($invest->last_update);
            $now = Carbon::now();
            $diff = $invest_time->diffInSeconds($now);

            if($period == 'week' and $diff > 604800){
                $diff = 604799;
            }elseif($period == 'month' and $diff > 2628288){
                $diff = 2628287;
            }elseif($period == '3months' and $diff > 7884864){
                $diff = 7884863;
            }elseif($period == '6months' and $diff > 15778463){
                $diff = 15778462;
            }elseif($period == '12months' and $diff > 31536000){
                $diff = 31535999;
            }
            
            $invest->spending_time = $diff;
            $invest->save();
        }

        return response()->json(['data' => $invests]);
    }

    public function getUserInvestments()
    {
        $invests = User::find(Auth::user()->id)->investments;

        foreach($invests as $invest){
            $period = $invest->return_period;
            $invest_time = Carbon::parse($invest->last_update);
            $now = Carbon::now();
            $diff = $invest_time->diffInSeconds($now);

            if($period == 'week' and $diff > 604800){
                $diff = 604799;
            }elseif($period == 'month' and $diff > 2628288){
                $diff = 2628287;
            }elseif($period == '3months' and $diff > 7884864){
                $diff = 7884863;
            }elseif($period == '6months' and $diff > 15778463){
                $diff = 15778462;
            }elseif($period == '12months' and $diff > 31536000){
                $diff = 31535999;
            }
            $invest->spending_time = $diff;
            $invest->save();
        }

        return response()->json(['data' => $invests]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'plan_name' => 'required|string',
            'amount' => 'required|numeric',
            'return_percent' => 'required|numeric',
            'return_period' => 'required|string|in:week,month,3months,6months,12months',
            'total_returned' => 'required|numeric',
            'wallet' => 'required|string|in:deposit,referral',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validator($request->all());
        if ($validatedData->fails())  {
            return response()->json(['errors'=>$validatedData->errors()], 400);
        }

        $info = Info::where('user_id', Auth::user()->id)->first();
        if(($request['wallet'] == 'deposit' and $info->Deposit_balance < $request['amount']) or
            ($request['wallet'] == 'referral' and $info->referral_earning < $request['amount'])){
            return response()->json(['data' => 'You dont have enough money!'], 400);
        }

        $return_amount = ($request['amount'] * $request['return_percent']) / 100.0;

        $invest = Investment::create([
            'user_id' => Auth::user()->id,
            'plan_name' => $request['plan_name'],
            'amount' => $request['amount'],
            'return_percent' => $request['return_percent'],
            'return_amount' => $return_amount,
            'return_period' => $request['return_period'],
            'total_returned' => $request['total_returned'],
            'wallet' => $request['wallet']
        ]);
        $invest->save();

        $info = Info::where('user_id', $invest->user_id)->first();
        if($invest->wallet == 'deposit'){
            $info->Deposit_balance -= $invest->amount;
        }elseif($invest->wallet == 'referral'){
            $info->referral_earning -= $invest->amount;
        }
        $info->total_invest += $invest->amount;
        $info->save();

        return response()->json(['data' => $invest]);
    }

    public function accept($id)
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }
        
        $invest = Investment::find($id);

        if(!$invest){
            return response()->json(['data' => 'There is no investment with this id !'], 400);
        }

        if($invest->state != 0){
            return response()->json(['data' => 'You cant do that'], 400);
        }

        $invest->state = 1;
        $invest->message = 'Process Statred';
        $invest->last_update = Carbon::now();
        $invest->save();


        $referral = Referral::where('user_referral', $invest->user_id)->first();
        if($referral and !$referral->done){
            $amount = 0;
            if($invest->amount >= 50 and $invest->amount <= 499){
                $amount = 10;
            }elseif($invest->amount >= 500 and $invest->amount <= 999){
                $amount = 15;
            }elseif($invest->amount >= 1000 and $invest->amount <= 2999){
                $amount = 20;
            }elseif($invest->amount >= 3000){
                $amount = 25;
            }
            
            $referral->benefit = $amount;
            $referral->done = 1;
            $referral->save();

            $user_info = Info::where('user_id', $referral->user_id)->first();
            $user_info->referral_earning += $amount;
            $user_info->save();
        }

        return response()->json(['data' => "Investment Accept"]);
    }

    public function cancel($id, Request $request)
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $invest = Investment::find($id);

        if(!$invest){
            return response()->json(['data' => 'There is no investment with this id !'], 400);
        }

        if($invest->state != 0){
            return response()->json(['data' => 'You cant do that'], 400);
        }

        $invest->state = 2;
        $invest->message = $request['message'];
        $invest->save();


        $info = Info::where('user_id', $invest->user_id)->first();
        if($invest->wallet == 'deposit'){
            $info->Deposit_balance += $invest->amount;
        }elseif($invest->wallet == 'referral'){
            $info->referral_earning += $invest->amount;
        }
        $info->total_invest -= $invest->amount;
        $info->save();

        return response()->json(['data' => "Investment Canceled"]);   
    }

    public function destroy($id)
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $invest = Investment::find($id);

        if(!$invest){
            return response()->json(['data' => 'There is no investment with this id !'], 400);
        }

        $invest->delete();
        return response()->json(['data' => "Investment Deleted"]);
    }
}
