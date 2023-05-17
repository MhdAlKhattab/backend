<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function getAllUsers(){
        $permission = Auth::user()->permission;
        if($permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $users = User::orderBy('created_at','desc')->get();

        return response()->json(['data' => $users]);
    }

    public function getNormalUsers(){
        $permission = Auth::user()->permission;
        if($permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $users = User::where('permission', 0)->orderBy('created_at','desc')->get();

        return response()->json(['data' => $users]);
    }

    public function getAdminUsers(){
        $permission = Auth::user()->permission;
        if($permission != 2){
            return response()->json(['data' => "Access Denied"], 403);   
        }

        $users = User::where('permission', 1)->orderBy('created_at','desc')->get();

        return response()->json(['data' => $users]);
    }
}
