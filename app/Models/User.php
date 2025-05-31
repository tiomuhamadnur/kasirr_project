<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $appends = ['photo_url', 'shop_photo_url'];
    protected $with = ['group', 'role', 'gender'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender_id',
        'role_id',
        'group_id',
        'phone',
        'photo',
        'birth_date',
        'email_verified_at',
        'address',
        'pin',
        'pin_verified_at',
        'shop_name',
        'shop_address',
        'shop_phone',
        'shop_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function photoUrl(): Attribute
    {
        return Attribute::get(fn () => $this->photo ? asset('storage/' . $this->photo) : null);
    }

    public function shopPhotoUrl(): Attribute
    {
        return Attribute::get(fn () => $this->shop_photo ? asset('storage/' . $this->shop_photo) : null);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
