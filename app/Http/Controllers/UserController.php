<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller{
	
    public function __construct()
    {
       parent::__construct();

    }

    public function index(Request $request){
        $users = User::all();
  	    return response()->json(['data' => $users], 200);
    }
	
	/* User Login*/
	public function authenticate(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
		
        $user = User::where('email', $request->input('email'))->first();  
        if(Hash::check($request->input('password'), $user->password)){
          $apikey = base64_encode(str_random(40));
          User::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;
          return response()->json(['status' => 'success','api_key' => $apikey]);
      }else{
          return response()->json(['status' => 'fail'],401);
      }
   }
   
    public function createUser(Request $request){
        
		$this->userValidationRules($request);
       
	   $user = User::create([
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password'))
                ]);

		$userinfo = Profile::create([
                    'user_id' => $user->id,
                    'first_name'=> $request->get('first_name'),
					'last_name'=> $request->get('last_name'),
					'address'=> $request->get('address'),
					'city'=> $request->get('city'),
					'country'=> $request->get('country'),
					'postal_code' => $request->get('country'),
                ]);
		
        return response()->json(['data' => "The user with with id {$user->id} has been created"], 201);
    }
	public function createPhysio(Request $request){
        
		$this->userValidationRules($request);
       
	   $user = User::create([
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
					'role' => 'DOCTOR'
                ]);

		$userinfo = Profile::create([
                    'user_id' => $user->id,
                    'first_name'=> $request->get('first_name'),
					'last_name'=> $request->get('last_name'),
					'address'=> $request->get('address'),
					'city'=> $request->get('city'),
					'country'=> $request->get('country'),
					'postal_code' => $request->get('postal_code'),
                ]);
		
        return response()->json(['data' => "The physio with with id {$user->id} has been created"], 201);
    }
    public function showUser($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => "The user with {$id} doesn't exist"], 404);
        }
        return response()->json(['data' => $user], 200);
    }
	
    public function updateUser(Request $request, $id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => "The user with {$id} doesn't exist"], 404);
        }
        $this->userValidationRules($request);
        $user->email        = $request->get('email');
        $user->password     = Hash::make($request->get('password'));
        $user->save();
        return response()->json(['data' => "The user with with id {$user->id} has been updated"], 200);
    }
	
    public function deleteUser($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => "The user with {$id} doesn't exist"], 404);
        }
        $user->delete();
        return response()->json(['data' => "The user with with id {$id} has been deleted"], 200);
    }
    public function userValidationRules(Request $request){
        $rules = [
            'email' => 'required|email|unique:users', 
            'password' => 'required|min:6',
			'first_name' => 'required',
			'last_name' => 'required',
			'address' => 'required',
			'city' => 'required',
			'country' => 'required',
			'postal_code' => 'required'
        ];
        $this->validate($request, $rules);
    }
   
}