<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     public function getTotalCount($mobile_no) 
    {
        $customUsername = 'mobile_no';
        return $this->where('mobile_no', $mobile_no)->count();
    }
     public function findForPassport($mobile_no) 
    {
        $customUsername = 'mobile_no';
        return $this->where('mobile_no', $mobile_no)->first();
    }
    protected $table='tbl_mobile_user';
    protected $primaryKey = 'code';
    protected $fillable = [
        'name', 'designation', 'mobile_no','password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
