<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Deposit;
use App\Models\Info;
use App\Models\User;

class DepositController extends Controller
{
    public function getAllDeposits()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $deposits = Deposit::with('User')->orderBy('created_at','desc')->get();
        return response()->json(['data' => $deposits]);
    }

    public function getAllPenddingDeposits()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $deposits = Deposit::with('User')->where('state', 0)->orderBy('created_at','desc')->get();
        return response()->json(['data' => $deposits]);
    }

    public function getAllCompleteDeposits()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $deposits = Deposit::with('User')->where('state', 1)->orderBy('created_at','desc')->get();
        return response()->json(['data' => $deposits]);
    }

    public function getAllCanceledDeposits()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }
        
        $deposits = Deposit::with('User')->where('state', 2)->orderBy('created_at','desc')->get();
        return response()->json(['data' => $deposits]);
    }

    public function getPanelDeposits()
    {
        $deposits = Deposit::with('User')->where('state', 1)->orderBy('created_at','desc')->take(10)->get();
        return response()->json(['data' => $deposits]);
    }

    public function getUserDeposits()
    {
        $deposits = User::find(Auth::user()->id)->deposits;
        return response()->json(['data' => $deposits]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'wallet' => 'required|string',
            'proccess_id' => 'required|string',
            'amount' => 'required|numeric',
            'method' => 'required|string',
            'photo' => ['required', 'image','mimes:jpeg,jpg,png'],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validator($request->all());
        if ($validatedData->fails())  {
            return response()->json(['errors'=>$validatedData->errors()], 400);
        }

        $deposit = Deposit::create([
            'user_id' => Auth::user()->id,
            'wallet' => $request['wallet'],
            'proccess_id' => $request['proccess_id'],
            'amount' => $request['amount'],
            'method' => $request['method'],
            'photo' => ''
        ]);

        if ($request->hasFile('photo')) {

            // Get filename with extension
            $filenameWithExt = $request->file('photo')->getClientOriginalName();

            // Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get extension
            $extension = $request->file('photo')->getClientOriginalExtension();

            // Create new filename
            $filenameToStore = $filename.'_'.time().'.'.$extension;

            // Uplaod image
            $path = $request->file('photo')->storeAs('public/deposit_images/', $filenameToStore);

            $deposit->photo = $filenameToStore;

        }

        $deposit->save();

        return response()->json(['data' => $deposit]);
    }

    public function accept($id, Request $request)
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }
        
        $deposit = Deposit::find($id);

        if(!$deposit){
            return response()->json(['data' => 'There is no deposit with this id !'], 400);
        }

        if($deposit->state != 0){
            return response()->json(['data' => 'You cant do that'], 400);
        }

        $deposit->state = 1;
        $deposit->message = $request['message'];
        $deposit->save();

        $info = Info::where('user_id', $deposit->user_id)->first();
        $info->Deposit_balance += $deposit->amount;
        $info->total_deposit += $deposit->amount;
        $info->save();

        return response()->json(['data' => "Deposit Accept"]);
    }

    public function cancel($id, Request $request)
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $deposit = Deposit::find($id);

        if(!$deposit){
            return response()->json(['data' => 'There is no deposit with this id !'], 400);
        }

        if($deposit->state != 0){
            return response()->json(['data' => 'You cant do that'], 400);
        }

        

        $deposit->state = 2;
        $deposit->message = $request['message'];
        $deposit->save();

        return response()->json(['data' => "Deposit Canceled"]);   
    }

    public function destroy($id)
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $deposit = Deposit::find($id);

        if(!$deposit){
            return response()->json(['data' => 'There is no deposit with this id !'], 400);
        }

        $deposit->delete();
        return response()->json(['data' => "Deposit Deleted"]);
    }
}
