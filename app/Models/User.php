<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable  implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'about',
        'phone_number',
        'company_name',
        'category',
        'address',
        'dob',
        'business_id',
        'role',
        'status',
        'service_no',
            'ippis_no',
            'grade_level',
            'step',
            'rank',
            'service_length',
            'retirement_date',
            'lga',
            'kin_name',
            'kin_address',
            'salary_account',
            'bank',
            'account_manager',
            'state'
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
    ];

    public function subscriptions()
    {
        return $this->hasMany(subscriptions::class, 'client_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(tasks::class, 'assigned_to', 'id');
    }
}
