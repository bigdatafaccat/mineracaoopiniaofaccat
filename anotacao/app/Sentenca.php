<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Sentenca
 *
 * @property int $idsentenca
 * @property string $post_id
 * @property string $sentenca_id
 * @property string $grupo_id
 * @property string $mongo_id
 * @property string $texto
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereGrupoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereIdsentenca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereMongoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereSentencaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereTexto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sentenca extends Model
{
    protected $primaryKey = 'idsentenca';
    protected $table = 'sentenca';
}
