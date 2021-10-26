<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'districts';
    protected $fillable = [
        'regency_id',
    	'name'
    ];

    public function user ()
    {
     	return $this->hasMany(User::class);
    }

}
