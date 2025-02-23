<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Backup extends Model
{
    use SoftDeletes;

    protected $table = 'backup';

    protected $guarded = [];
    protected $appends = ['file_url'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function fileUrl(): Attribute
    {
        return Attribute::get(fn () => $this->file ? asset('storage/' . $this->file) : null);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
