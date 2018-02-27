<?php

namespace App\Http\Controllers;
use App\Profile;
use App\User;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller{
	
	
	public function showProfile($id){
		$user = User::find($id);
        if(!$user){
            return response()->json(['message' => "The user with {$id} doesn't exist"], 404);
        }
		$userInfo = User::with('profile')->findOrFail($id);
        return response()->json(['data' => $userInfo], 200);
    }
    public function updateProfile(Request $request, $id){
        $user = User::find($id);
		
		$profile = Profile::find($user->id);
        if(!$user){
            return response()->json(['message' => "The user with {$id} doesn't exist"], 404);
        }
		
        $this->userValidationRules($request);
		
        $profile->first_name        = $request->get('first_name');
        $profile->last_name     =  $request->get('last_name');
		$profile->address     =  $request->get('address');
		$profile->city     =  $request->get('city');
		$profile->country     =  $request->get('country');
		$profile->postal_code     =  $request->get('postal_code');
        $profile->save();
        return response()->json(['data' => "The user with with id {$user->id} has been updated"], 200);
    }
   
    public function userValidationRules(Request $request){
        $rules = [
			'first_name' => 'required'
        ];
        $this->validate($request, $rules);
    }
    
}