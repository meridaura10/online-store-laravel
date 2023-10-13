<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $keyType = 'string';

    public $incrementing = false;


    protected $fillable = [
        'id',
        'name',
    ];
    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%$value%");
    }
    public function scopeWhithCities($query){
        $query->whereHas('cities');
    }
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
