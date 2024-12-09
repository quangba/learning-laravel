<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description'
    ];
    protected $table = 'categories';
    protected $primaryKey = 'id';
    public function foods()
    {
        return $this->hasMany(Foods::class);
    }
}
