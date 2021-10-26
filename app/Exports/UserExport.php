<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select(
        'id',
        'name',,
        'email',
        'hp',
        'provinsi_id',
        'kota_id',
        'kecamatan_id'
        'alamat',
        'role',
        'updated_at'
        )->get();
    }
}
