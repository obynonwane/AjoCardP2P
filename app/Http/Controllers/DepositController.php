<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Model\Deposit;
use App\Model\Transaction;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'amount'=>'required|numeric',            
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['amount_deposited'] = $request->amount;
        $data['deposit_reference'] = str_random(45);
        $data['status'] = 'success';
        $deposit = Deposit::create($data);


        
        //update the Receiver wallet_balance
        $receiver_update = User::findOrFail(Auth::user()->id);
        $receiver_update->wallet_balance = abs($receiver_update->wallet_balance + $request->amount);
        $receiver_update->save();


        return response()->json(['data'=>$deposit], 200);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit $deposit)
    {
        //
    }
}
