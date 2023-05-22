<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Withdraw;
use App\Models\Info;
use App\Models\User;

class WithdrawController extends Controller
{
    public function getAllWithdraws()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $withdraws = Withdraw::with('User')->orderBy('created_at','desc')->get();
        return response()->json(['data' => $withdraws]);
    }

    public function getAllPenddingWithdraws()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $withdraws = Withdraw::with('User')->where('state', 0)->orderBy('created_at','desc')->get();
        return response()->json(['data' => $withdraws]);
    }

    public function getAllCompleteWithdraws()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $withdraws = Withdraw::with('User')->where('state', 1)->orderBy('created_at','desc')->get();
        return response()->json(['data' => $withdraws]);
    }

    public function getAllCanceledWithdraws()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }
        
        $withdraws = Withdraw::with('User')->where('state', 2)->orderBy('created_at','desc')->get();
        return response()->json(['data' => $withdraws]);
    }

    public function getPanelWithdraws()
    {
        $withdraws = Withdraw::with('User')->where('state', 1)->orderBy('created_at','desc')->take(10)->get();
        return response()->json(['data' => $withdraws]);
    }

    public function getUserWithdraws()
    {
        $withdraws = User::find(Auth::user()->id)->withdraws;
        return response()->json(['data' => $withdraws]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'wallet' => 'required|string',
            'amount' => 'required|numeric',
            'method' => 'required|string',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validator($request->all());
        if ($validatedData->fails())  {
            return response()->json(['errors'=>$validatedData->errors()], 400);
        }

        $info = Info::where('user_id', Auth::user()->id)->first();
        if($info->interest_balance < $request['amount']){
            return response()->json(['data' => 'You dont have enough money!'], 400);
        }

        $charge = ($request['amount'] * 2) / 100.0;
        $receivable = $request['amount'] - $charge;

        $withdraw = Withdraw::create([
            'user_id' => Auth::user()->id,
            'wallet' => $request['wallet'],
            'amount' => $request['amount'],
            'method' => $request['method'],
            'charge' => $charge,
            'receivable' => $receivable,
        ]);
        $withdraw->save();

        $info->interest_balance -= $withdraw->amount;
        $info->total_withdraw += $withdraw->amount;
        $info->save();

        return response()->json(['data' => $withdraw]);
    }

    public function accept($id, Request $request)
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $withdraw = Withdraw::find($id);

        if(!$withdraw){
            return response()->json(['data' => 'There is no withdraw with this id !'], 400);
        }

        if($withdraw->state != 0){
            return response()->json(['data' => 'You cant do that'], 400);
        }

        $withdraw->state = 1;
        $withdraw->message = $request['message'];
        $withdraw->save();

        return response()->json(['data' => "Withdraw Accept"]);
    }

    public function cancel($id, Request $request)
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $withdraw = Withdraw::find($id);

        if(!$withdraw){
            return response()->json(['data' => 'There is no withdraw with this id !'], 400);
        }

        if($withdraw->state != 0){
            return response()->json(['data' => 'You cant do that'], 400);
        }

        $withdraw->state = 2;
        $withdraw->message = $request['message'];
        $withdraw->save();

        $info = Info::where('user_id', $withdraw->user_id)->first();
        $info->interest_balance += $withdraw->amount;
        $info->total_withdraw -= $withdraw->amount;
        $info->save();

        return response()->json(['data' => "Withdraw Canceled"]);   
    }

    public function destroy($id)
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }
        
        $withdraw = Withdraw::find($id);

        if(!$withdraw){
            return response()->json(['data' => 'There is no withdraw with this id !'], 400);
        }

        $withdraw->delete();
        return response()->json(['data' => "Withdraw Deleted"]);
    }
}
