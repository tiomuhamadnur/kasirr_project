<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Promo extends Model
{
    use SoftDeletes;

    protected $table = 'promo';

    protected $guarded = [];

    protected $appends = ['file_url'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->user_id = Auth::user()->id;
        });

        self::updating(function ($model) {
            $model->user_id = Auth::user()->id;
        });
    }

    public function fileUrl(): Attribute
    {
        return Attribute::get(fn () => $this->file ? asset('storage/' . $this->file) : null);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
