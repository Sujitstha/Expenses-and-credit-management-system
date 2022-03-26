<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CashFlowResource;
use App\Models\Api\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashFlowController extends Controller
{
    //Income List
    public function income()
    {
        $income = Transaction::where('category_id',1)->where('user_id',Auth::user()->id)->get();
        return CashFlowResource::collection($income);
    }


    //Expansive List
    public function expense()
    {
        $income = Transaction::where('category_id',2)->where('user_id',Auth::user()->id)->get();
        return CashFlowResource::collection($income);
    }

    public function totalIncome()
    {
        $totalIncome = Transaction::where('category_id',1)->where('user_id',Auth::user()->id)->sum('amount');
        return response()->json(['totalIncome' => $totalIncome]);

    }

    public function totalExpenses()
    {
        $totalExpanses = Transaction::where('category_id',2)->where('user_id',Auth::user()->id)->sum('amount');
        return response()->json(['totalExpenses' => $totalExpanses]);

    }


}
