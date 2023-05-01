<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Investment;
use App\Models\Info;
use App\Models\User;

class InvestmentController extends Controller
{
    public function getAllInvestments()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $invests = Investment::with('User')->orderBy('created_at','desc')->get();
        return response()->json(['data' => $invests]);
    }

    public function getUserInvestments()
    {
        $invests = User::find(Auth::user()->id)->investments;
        return response()->json(['data' => $invests]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'plan_name' => 'required|string',
            'amount' => 'required|numeric',
            'return_percent' => 'required|numeric',
            'return_period' => 'required|string|in:week,month',
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

        $invest = Investment::create([
            'user_id' => Auth::user()->id,
            'plan_name' => $request['plan_name'],
            'amount' => $request['amount'],
            'return_percent' => $request['return_percent'],
            'return_period' => $request['return_period'],
            'total_returned' => $request['total_returned'],
            'wallet' => $request['wallet']
        ]);
        $invest->save();

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
        $invest->save();

        $info = Info::where('user_id', $invest->user_id)->first();
        if($invest->wallet == 'deposit'){
            $info->Deposit_balance -= $invest->amount;
        }elseif($invest->wallet == 'referral'){
            $info->referral_earning -= $invest->amount;
        }
        $info->total_invest += $invest->amount;
        $info->save();

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
