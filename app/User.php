<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

	protected $guarded = ['id'];
	protected $hidden = ['password'];
	protected $appends = ['added_date'];


    public function getAddedDateAttribute()
    {
        $date = Carbon::parse($this->created_at)->format('M j, Y');
        return $date;
    }
}
