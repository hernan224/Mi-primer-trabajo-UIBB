<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    public const CATEGORIA_PRACTICAS = 'practicas';
    public const CATEGORIA_CAPACITACIONES = 'capacitaciones';

    protected $table = 'publicaciones';

    protected $fillable = [
        'titulo','categoria','texto','borrador'
    ];

    public static $image_path = 'media/img/publicaciones';
    // Si sube imagen, esta va a ser guardada en esa carpeta con nombre <id_publicacion>_randomstring.<tipo_img>

    /**
     * Relacion M:1 con User (autor de la publicación)
     */
    public function autor() {
        return $this->belongsTo(User::class);
    }

    public function getUrlImagen() {
        if ($this->imagen) {
            return asset(self::$image_path.'/'.$this->imagen);
        }
        else return false;
    }

}
