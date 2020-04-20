<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tabel_jenis extends Model
{
    protected $table="jenis_mobil";
    protected $tableprimaryKey="id_jenis";
    public $timestamps=false;

    protected $fillable = [
        'nama_jenis', 'harga_perhari'
    ];
}
