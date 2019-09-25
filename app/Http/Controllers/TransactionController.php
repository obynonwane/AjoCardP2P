<?php

namespace App\Http\Controllers;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Request;
use App\Model\Transaction;
use App\Model\Deposit;
use App\User;
use Auth;
use DB;

class TransactionController extends Controller
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
        $transactions = Transaction::all();

        return response()->json(['data'=>$transactions],200);
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
    public function store(TransactionRequest $request)
    {
       //Transaction Facade
        $transaction = DB::transaction(function () use($request) {

            $wallet_id = $request->wallet_id;
            $receiver = User::where('wallet_id', $wallet_id)->first();

            if(Auth::user()->pin != $request->pin){
                return response()->json(['error'=>'Incorrect 4 digit Pin supplied', 'code' => 422], 422);
            }

            if(!$receiver){
                return response()->json(['error'=>'Incorrect Receiever Wallet ID Supplied', 'code' => 422], 422);
            }

            if(Auth::user()->wallet_balance < $request->amount){
                return response()->json(['error'=>'Insufficient Fund, Please Fund your Account', 'code' => 422], 422);
            }

            if($request->amount == 0){
                return response()->json(['error'=>'You can not sent Zero (0) Amount', 'code' => 422], 422);
            }

            try{
             //Submit Transaction 
             $transaction = new Transaction;
             $transaction->sender_id = Auth::user()->id;
             $transaction->receiver_id = $receiver->id;
             $transaction->transaction_reference = str_random(40);
             $transaction->amount_sent = $request->amount;
             $transaction->amount_received = $request->amount;
             $transaction->save();


             //update the Receiver wallet_balance
             $receiver_update = User::findOrFail($receiver->id);
             $receiver_update->wallet_balance = abs($receiver_update->wallet_balance + $request->amount);
             $receiver_update->save();

             //update the Sender wallet_balance
             $sender_update = User::findOrFail(Auth::user()->id);
             $sender_update->wallet_balance = abs($sender_update->wallet_balance - $request->amount);
             $sender_update->save();

            }
            catch(Exception $e){
                return response()->json(['error'=>'Transaction Failed', 'code' => 422], 422);
            }
      
            return response()->json(['data'=>$transaction], 201);
            
        });
        //response
        return response()->json(['response'=>$transaction, 'code' => 201], 201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        return response()->json(['data'=>$transaction], 200);       

       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
