<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Deposit;
use App\Model\Transaction;
use Auth;

class UserController extends Controller
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
        $users = User::all();
        return response()->json(['data'=>$users], 200);
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
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',
            'pin'=>'required|numeric|min:4',
            
        ];
        $this->validate($request, $rules);

        $data = $request->all();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['wallet_id'] = str_random(12);
        $data['pin'] = $request->pin;        
        $data['password'] = bcrypt($request->password);     
        
        $user = User::create($data);

        return response()->json(['data'=>$data], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['data'=>$user], 200);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $user = User::findOrFail($id);

        $rules = [

            'email'=>'required|email|unique:users,email' . $user->id,
            'password'=>'required|min:6|confirmed',            
        ];

        if($request->has('name')){
            $user->name = $request->name;
        }

        if($request->has('email')){
            $user->name = $request->email;
        }

        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }   

        if($request->has('wallet_id')){
           return response()->json(['error'=>'You Can not Change Your Wallet ID', 'code' => 409], 409);
        }

        if($request->has('wallet_balance')){
            $user->wallet_balance = $request->wallet_balance + $user->wallet_balance;
         }

         if(!$user->isDirty()){
            return response()->json(['error'=>'You Need to specify a different value to Update', 'code' => 422], 422);
         }

         
         $user->save();

         //Add to Deposits Table
         $deposit = new Deposit;
         $deposit->user_id = $user->id;
         $deposit->amount_deposited = $request->wallet_balance;
         $deposit->deposit_reference = str_random(45);
         $deposit->status = 'success';
         $deposit->save();


         return response()->json(['data'=>$user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
