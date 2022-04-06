<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Credit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Credit::orderBy('id','desc')->where('user_id',Auth::user()->id)->get();
        return response()->json($loans);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loan = new Credit();
        $loan->name = $request->name;
        $loan->address = $request->address;
        $loan->mobile = $request->mobile;
        $loan->purpose = $request->purpose;
        $loan->amount = $request->amount;
        $loan->due_date = $request->due_date;
        $loan->remarks = $request->remarks;
        $loan->user_id = Auth::user()->id;
        $loan->save();
        $response = Http::post('http://sms.codeitapps.com/api/v3/sms?',[
            'token' => 'w6ZlvtLHCfZaqPWY1605I3XDo0U7MLUzEmu1',
            'to' => $request->mobile,
            'sender' => 'CodeIT',
            'message' => "Dear {$request->name}\n you have due of Rs. {$request->amount}\n purpose: {$request->purpose}\n Thank you."
        ]);
        return response()->json(['message','Record Saved Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $loan =  Credit::find($id);
        $loan->name = $request->name;
        $loan->address = $request->address;
        $loan->mobile = $request->mobile;
        $loan->purpose = $request->purpose;
        $loan->amount = $request->amount;
        $loan->due_date = $request->due_date;
        $loan->remarks = $request->remarks;
        $loan->user_id = Auth::user()->id;
        $loan->update();
        $response = Http::post('http://sms.codeitapps.com/api/v3/sms?',[
            'token' => 's3Xs93M1KgsjARbH1611QG8zKSitQjY4k7gz',
            'to' => $request->mobile,
            'sender' => 'Demo',
            'message' => "Dear {$request->name}\n you have due of Rs. {$request->amount}\n purpose: {$request->purpose}\n Thank you."
        ]);
        return response()->json(['message','Record Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $credit = Credit::find($id);
        $credit->delete();
        return response()->json(['message'=>'Record Deleted Successfully']);
    }
}
