<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Publicacion
 *
 * @property integer $id
 * @property string $titulo
 * @property integer $autor_id
 * @property string $categoria
 * @property string $texto
 * @property string $imagen
 * @property boolean $borrador
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $autor
 * @method static \Illuminate\Database\Query\Builder|Publicacion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|Publicacion whereTitulo($value)
 * @method static \Illuminate\Database\Query\Builder|Publicacion whereAutorId($value)
 * @method static \Illuminate\Database\Query\Builder|Publicacion whereCategoria($value)
 * @method static \Illuminate\Database\Query\Builder|Publicacion whereTexto($value)
 * @method static \Illuminate\Database\Query\Builder|Publicacion whereImagen($value)
 * @method static \Illuminate\Database\Query\Builder|Publicacion whereBorrador($value)
 * @method static \Illuminate\Database\Query\Builder|Publicacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Publicacion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Publicacion extends Model
{
    const CATEGORIA_PRACTICAS = 'practicas';
    const CATEGORIA_CAPACITACIONES = 'capacitaciones';

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

    /**
     * Formatea fecha al obtener updated_at
     * @param $value
     * @return null|string
     */
    public function getUpdatedAtAttribute($value)
    {
        $date = new \DateTime($value);
        return $date->format('d/m/Y');
    }

}
