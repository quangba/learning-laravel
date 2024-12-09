<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'count',
        'description',
        'category_id',
        'image_path',
    ];
    protected $table = 'foods';
    protected $primaryKey = 'id';
    public $timestamps = true;


    public function category()
    {

        return $this->belongsTo(Category::class);
    }
}
