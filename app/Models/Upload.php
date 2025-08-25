<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'uploads';      // Nama tabel
    protected $primaryKey = 'Id_Upload'; // Primary key

    public $timestamps = false;

    protected $fillable = [
        'Video_Path_Upload',
        'Desc_Upload',
    ];
}
