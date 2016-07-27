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

    /**
     * Atributos agregados al serializar
     */
    protected $appends = ['autor_nombre','categoria_trans','texto_preview', 'url_imagen'];

    /**
     * Atributos no incluidos al serializar
     */
    protected $hidden = ['texto', 'created_at','imagen','autor'];

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

    /**
     * Obtener ul imagen: (atributo url_imagen)
     * @return bool|string
     */
    public function getUrlImagenAttribute(){
        return $this->getUrlImagen();
    }

    /**
     * Obtener preview texto (atributo texto_preview)
     */
    public function getTextoPreviewAttribute() {
        $texto_sin_html = strip_tags($this->texto);
        return mb_strimwidth($texto_sin_html,0,250,'...');
    }

    /**
     * Obtener nombre autor (atributo autor_nombre)
     */
    public function getAutorNombreAttribute() {
        return $this->autor->name;
    }

    /**
     * Obtener categoría traducida (atributo categoria_trans)
     * @return string
     */
    public function getCategoriaTransAttribute(){
        return trans('app.'.$this->categoria);
    }
}
