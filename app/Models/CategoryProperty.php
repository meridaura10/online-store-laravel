<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProperty extends Model
{
    use HasFactory;

    protected $table = 'category_property';

    protected $fillable = ['category_id', 'property_id'];

}
