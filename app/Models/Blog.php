<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'blog';
    protected $fillable = [
    	'user_id',
    	'tanggal',
    	'judul',
    	'slug',
    	'meta',
    	'tag',
        'kategori_id',
    	'featured',
    	'konten',
    	'status'
    ];

    public function user ()
    {
     	return $this->belongsTo(User::class);
    }

    public function kategori ()
    {
        return $this->belongsTo(Kategori::class);
    }

}
