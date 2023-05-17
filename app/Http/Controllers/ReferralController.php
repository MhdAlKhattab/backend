<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;
use App\Models\User;

class ReferralController extends Controller
{
    public function getAllReferrals()
    {
        $permission = Auth::user()->permission;
        if($permission == 0){
            return response()->json(['data' => "Access Denied"], 403);
        }

        // $referrals = Referral::from( 'referrals as ref' )
        // ->join('users', 'ref.user_id', '=', 'users.id')
        // ->select('ref.user_referral', 'ref.benefit',
        //  'ref.done', 'ref.updated_at','users.first_name AS user_first_name',
        // 'users.last_name AS user_last_name', 'users.email AS user_email')
        //  ->join('users', 'user_email', '=', 'users.email')
        // ->get();

        $referrals = Referral::with('User')->get();
        // ->join('users', 'ref.user_id', '=', 'users.id')


        return response()->json(['data' => $referrals]);
    }

    public function getUserReferrals()
    {
        $permission = Auth::user()->permission;
        if($permission != 0){
            return response()->json(['data' => "Access Denied"], 403);
        }

        $referrals = Referral::where('user_id', '=', Auth::user()->id)
        ->join('users', 'referrals.user_referral', '=', 'users.id')
        ->select('user_referral', 'first_name', 'last_name', 'email', 'referrals.created_at')
        ->get();

        return response()->json(['data' => $referrals]);
    }

    public function getUserBenfitReferrals()
    {
        $permission = Auth::user()->permission;
        if($permission != 0){
            return response()->json(['data' => "Access Denied"], 403);
        }

        $referrals = Referral::where([

            ['user_id', '=', Auth::user()->id],
            ['done', '=', 1]
    
        ])
        ->join('users', 'referrals.user_referral', '=', 'users.id')
        ->select('user_referral', 'first_name', 'last_name', 'benefit', 'email', 'referrals.updated_at')
        ->get();

        return response()->json(['data' => $referrals]);
    }
}
