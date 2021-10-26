<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'regencies';
    protected $fillable = [
        'province_id',
    	'name'
    ];

    public function user ()
    {
     	return $this->hasMany(User::class);
    }

}
