<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['id','path','disk','order','relation_type','relation_id'];
    public function relation()
    {
        return $this->morphTo();
    }
    protected function url(): Attribute
    {
        return new Attribute(
            get: fn () => Storage::disk($this->disk)->url($this->path),
        );
    }
}
