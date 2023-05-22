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


        $total_pendding_deposits = Deposit::where('state', '=', 0)->sum('amount');
        $total_complete_deposits = Deposit::where('state', '=', 1)->sum('amount');
        $total_canceled_deposits = Deposit::where('state', '=', 2)->sum('amount');

        $total_pendding_withdraws = Withdraw::where('state', '=', 0)->sum('amount');
        $total_complete_withdraws = Withdraw::where('state', '=', 1)->sum('amount');
        $total_canceled_withdraws = Withdraw::where('state', '=', 2)->sum('amount');

        $total_pendding_invest = Investment::where('state', '=', 0)->sum('amount');
        $total_progress_invest = Investment::where('state', '=', 1)->sum('amount');
        $total_canceled_invest = Investment::where('state', '=', 2)->sum('amount');
        $total_complete_invest = Investment::where('state', '=', 3)->sum('amount');


        return response()->json(['data' => [
            'num_admin_users' => $num_admin_users,
            'num_normal_users' => $num_normal_users,

            'total_pendding_deposits' => $total_pendding_deposits,
            'total_complete_deposits' => $total_complete_deposits,
            'total_canceled_deposits' => $total_canceled_deposits,

            'total_pendding_withdraws' => $total_pendding_withdraws,
            'total_complete_withdraws' => $total_complete_withdraws,
            'total_canceled_withdraws' => $total_canceled_withdraws,

            'total_pendding_invest' => $total_pendding_invest,
            'total_progress_invest' => $total_progress_invest,
            'total_canceled_invest' => $total_canceled_invest,
            'total_complete_invest' => $total_complete_invest,
            ]]);
    }
}
