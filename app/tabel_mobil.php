<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tabel_mobil extends Model
{
    protected $table="mobil";
    protected $tableprimaryKey="id_mobil";
    public $timestamps=false;

    protected $fillable = [
        'nama_mobil', 'plat_mobil','kondisi','id_jenis_mobil'
    ];
}
