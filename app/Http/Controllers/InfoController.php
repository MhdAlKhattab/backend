<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class InfoController extends Controller
{
    public function index(){
        
        $info = User::find(Auth::user()->id)->info;

        return response()->json(['data' => $info]);   
    }
}
