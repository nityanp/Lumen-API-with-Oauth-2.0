<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
   use Authenticatable, Authorizable, HasApiTokens;
	
	const USER_ROLE = 'USER';
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'users';
	
	//public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'email','status', 'role', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];
	
	/**
	 * One to Many relation
	 *
	 */
	public function profile() 
	{
		return $this->hasOne('App\Profile', 'user_id');
	}
	
	/**
     * Verify user's credentials.
     * @param  string $email
     * @param  string $password
     * @return int|boolean
     */
    public function verify($email, $password){

        $user = User::where('email', $email)->first();

        if($user && Hash::check($password, $user->password)){
            return $user->id;
        }

        return false;
    }
}
