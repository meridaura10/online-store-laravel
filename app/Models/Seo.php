<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;
    use Translatable;
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['url', 'relation_type', 'relation_id'];

    public function relation()
    {
        return $this->morphTo();
    }
}
