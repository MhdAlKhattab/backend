<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\Investment;

class StatisticController extends Controller
{
    public function getStatistics()
    {
        $permission = Auth::user()->permission;
        if($permission == 0){
            return response()->json(['data' => "Access Denied"], 403);
        }

        $num_admin_users = count(User::where('permission', '=', 1)->get());
        $num_normal_users = count(User::where('permission', '=', 0)->get());


        $num_pendding_deposits = count(Deposit::where('state', '=', 0)->get());
        $num_complete_deposits = count(Deposit::where('state', '=', 1)->get());
        $num_canceled_deposits = count(Deposit::where('state', '=', 2)->get());

        $num_pendding_withdraws = count(Withdraw::where('state', '=', 0)->get());
        $num_complete_withdraws = count(Withdraw::where('state', '=', 1)->get());
        $num_canceled_withdraws = count(Withdraw::where('state', '=', 2)->get());

        $num_pendding_invest = count(Investment::where('state', '=', 0)->get());
        $num_progress_invest = count(Investment::where('state', '=', 1)->get());
        $num_canceled_invest = count(Investment::where('state', '=', 2)->get());
        $num_complete_invest = count(Investment::where('state', '=', 3)->get());


        return response()->json(['data' => [
            'num_admin_users' => $num_admin_users,
            'num_normal_users' => $num_normal_users,

            'num_pendding_deposits' => $num_pendding_deposits,
            'num_complete_deposits' => $num_complete_deposits,
            'num_canceled_deposits' => $num_canceled_deposits,

            'num_pendding_withdraws' => $num_pendding_withdraws,
            'num_complete_withdraws' => $num_complete_withdraws,
            'num_canceled_withdraws' => $num_canceled_withdraws,

            'num_pendding_invest' => $num_pendding_invest,
            'num_progress_invest' => $num_progress_invest,
            'num_canceled_invest' => $num_canceled_invest,
            'num_complete_invest' => $num_complete_invest,
            ]]);
    }
}
