<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SkuImage extends Model
{
    use HasFactory;

    protected $fillable = ['disk', 'path', 'order', 'sku_id'];

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
    protected function url(): Attribute
    {
        return new Attribute(
            get: fn () => Storage::disk('local')->url($this->path),
        );
    }
}
