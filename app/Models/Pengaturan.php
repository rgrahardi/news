<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengaturan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengaturan';
    protected $fillable = [
    	'user_id',
    	'nama',
    	'output',
    	'nilai',
        'status'
    ];

    public function user ()
    {
     	return $this->belongsTo(User::class);
    }

}
