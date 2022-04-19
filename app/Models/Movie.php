<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['e_id', 'title', 'description', 'poster', 'banner', 'type', 'release_date', 'vote', 'vote_count'];

    protected $appends = ['poster_path', 'banner_path'];

    //atr
    public function getPosterPathAttribute()
    {
        return 'https://image.tmdb.org/t/p/w500' . $this->poster;
    }

    public function getBannerPathAttribute()
    {
        return 'https://image.tmdb.org/t/p/w500' . $this->banner;
    }

    //scope
    public function scopeWhenGenreId($query, $genreId)
    {
        return $query->when($genreId, function ($q) use ($genreId) {

            return $q->whereHas('genres', function ($qu) use ($genreId) {

                return $qu->where('genres.id', $genreId);
            });

        });
    }

    public function scopeWhenActorId($query, $actorId)
    {
        return $query->when($actorId, function ($q) use ($actorId) {

            return $q->whereHas('actors', function ($qu) use ($actorId) {

                return $qu->where('actors.id', $actorId);
            });

        });

    }

    //rel
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'movie_actor');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    //fun

}
