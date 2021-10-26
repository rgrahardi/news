<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'hp',
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'alamat',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function provinsi ()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kota ()
    {
        return $this->belongsTo(Kota::class);
    }

    public function kecamatan ()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function blog ()
    {
        return $this->hasMany(Blog::class);
    }

    public function pengaturan ()
    {
        return $this->hasMany(Pengaturan::class);
    }
}
