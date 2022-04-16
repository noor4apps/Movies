<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'type', 'image'];

    protected $hidden = ['password', 'remember_token',];

    protected $appends = ['image_path'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //atr
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),
            set: fn($value) => strtolower($value),
        );
    }

    public function getImagePathAttribute(): string
    {
        if ($this->image) {
            return Storage::url('uploads/' . $this->image);
        }

        return asset('admin_assets/images/default.png');
    }

    //scope
    public function scopeWhenRoleId($query, $roleId)
    {
        return $query->when($roleId, function ($q) use ($roleId) {

            return $q->whereHas('roles', function ($qu) use ($roleId) {

                return $qu->where('id', $roleId);
            });

        });

    }

    //rel

    //fun
    public function hasImage(): bool
    {
        return $this->image != null;
    }

}
