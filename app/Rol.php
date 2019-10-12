<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table ='roles';
    protected $primaryKey='id';
    public $timestamps = false;
    protected $fillable=[
        'id',
        'descripcion',
        'rol',
        'fecha_registro',
        'estado',
    ];

    public function usuarios(){
        return $this->belongsToMany(User::class, 'user_rol', 'user_id', 'rol_id');
   }


}
