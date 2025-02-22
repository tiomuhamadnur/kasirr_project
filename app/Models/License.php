<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class License extends Model
{
    use SoftDeletes;

    protected $table = 'license';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->key = self::generate_key();
        });
    }

    private static function generate_key()
    {
        do {
            $key = strtoupper(
                substr(Str::random(10), 0, 5) . '-' .
                substr(Str::random(10), 0, 5) . '-' .
                substr(Str::random(10), 0, 5) . '-' .
                substr(Str::random(10), 0, 5)
            );

            $exists = License::where('key', $key)->exists();

        } while ($exists); // Ulangi sampai mendapatkan key yang unik

        return $key;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
