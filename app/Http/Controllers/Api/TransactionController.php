<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Api\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recentTransaction = Transaction::orderBy('id','desc')->where('user_id',Auth::user()->id)->limit(5)->get();
        return TransactionResource::collection($recentTransaction);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transaction = new Transaction();
        $transaction->date = $request->date;
        $transaction->category_id = $request->category_id;
        $transaction->sub_category_id = $request->sub_category_id;
        $transaction->amount = $request->amount;
        $transaction->user_id = Auth::user()->id;
        $transaction->remarks = $request->remarks;
        $transaction->save();
        return response()->json([
            'message' => 'Record Saved Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $transaction->date = $request->date;
        $transaction->category_id = $request->category_id;
        $transaction->sub_category_id = $request->sub_category_id;
        $transaction->amount = $request->amount;
        $transaction->user_id = Auth::user()->id;
        $transaction->remarks = $request->remarks;
        $transaction->update();
        return response()->json([
            'message' => 'Record Updated Successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return response()->json(['message'=>'Transaction Deleted']);
    }
}
