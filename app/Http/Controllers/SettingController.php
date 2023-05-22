<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class SettingController extends Controller
{
    public function initSettings()
    {
        if(count(Setting::get()) == 0){
            $data = [
                ['name' => 'allow_deposit', 'value' => 1],
                ['name' => 'allow_withdraw', 'value' => 1],
                ['name' => 'allow_investment', 'value' => 1],
            ];
    
            foreach($data as $row) {
                DB::table('settings')->insert(
                  ['name' => $row['name'], 'value' =>$row['value']]
                );
             }
        }
    }

    public function depositTurnOn()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);
        }

        $setting = Setting::where('name', 'allow_deposit')->first();
        $setting->value = 1;
        $setting->save();

        return response()->json(['data' => "Deposit On"]);
    }

    public function depositTurnOff()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $setting = Setting::where('name', 'allow_deposit')->first();
        $setting->value = 0;
        $setting->save();

        return response()->json(['data' => "Deposit Off"]);
    }

    public function withdrawTurnOn()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);
        }

        $setting = Setting::where('name', 'allow_withdraw')->first();
        $setting->value = 1;
        $setting->save();

        return response()->json(['data' => "Withdraw On"]);
    }

    public function withdrawTurnOff()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $setting = Setting::where('name', 'allow_withdraw')->first();
        $setting->value = 0;
        $setting->save();

        return response()->json(['data' => "Withdraw Off"]);
    }

    public function investTurnOn()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);
        }

        $setting = Setting::where('name', 'allow_investment')->first();
        $setting->value = 1;
        $setting->save();

        return response()->json(['data' => "Investment On"]);
    }

    public function investTurnOff()
    {
        $permission = Auth::user()->permission;
        if($permission != 1 and $permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $setting = Setting::where('name', 'allow_investment')->first();
        $setting->value = 0;
        $setting->save();

        return response()->json(['data' => "Investment Off"]);
    }
}
