<?php

namespace App\Models;

use App\Models\attribute;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attributeValue extends Model
{
    use HasFactory;
    use Translatable;
    public $translatedAttributes = ['value'];
    protected $fillable = ['attribute_id'];

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

}
