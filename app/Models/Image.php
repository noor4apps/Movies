<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'movie_id'];

    protected $appends = ['image_path'];

    // attr
    public function getImagePathAttribute()
    {
        if ($this->image) {
            return 'https://image.tmdb.org/t/p/w500' . $this->image;
        }
    }

    //scope

    //rel
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    //fun

}
