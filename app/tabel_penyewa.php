<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tabel_penyewa extends Model
{
    protected $table="penyewa";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'nama', 'nik', 'foto_ktp','telp','alamat'
    ];
}
