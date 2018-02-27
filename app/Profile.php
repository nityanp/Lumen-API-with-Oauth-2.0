<?php 

namespace App;
  
use Illuminate\Database\Eloquent\Model;
  
class Profile extends Model 
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'userinfo';
	
	protected $fillable = [
         'user_id','first_name', 'last_name','address', 'city', 'country', 'postal_code'
    ];
	
	public $timestamps = false;
	/**
	 * One to Many relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\hasMany
	 */	
	public function user() 
	{
	  return $this->belongsTo('App\User');
	}
     
}