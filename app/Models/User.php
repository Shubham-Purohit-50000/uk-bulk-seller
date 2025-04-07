<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Attendence;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
	    'name', 'email', 'password', 'added_by', 'level_id', 'parent_company', 'commission', 'address', 'phone', 'latitude', 'longitude', 'images'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // $user->assignRole('user-businesses');
    // if(auth()->user()->hasRole('user-businesses')) {
    //     // Display business prices
    // }

    public function rm()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function clients()
    {
        return $this->hasMany(User::class, 'added_by', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id', 'id');
    }

    public function attendence()
    {
        return $this->hasOne(Attendence::class)
            ->whereDate('date', now()->toDateString());
    }

    public function tieUpProducts()
    {
        return $this->hasMany(StoreTieUpProduct::class, 'store_id', 'id');
    }

    public function parentCompany()
    {
        return $this->belongsTo(User::class, 'parent_company', 'id');
    }

    public function franchises()
    {
        return $this->hasMany(User::class, 'parent_company', 'id');
    }

    public function epos()
    {
        return $this->hasMany(User::class, 'parent_company', 'id');
    }

}
