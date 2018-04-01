<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reacao
 *
 * @property int $idreacao
 * @property string|null $post_id
 * @property string|null $comentario_id
 * @property string|null $autor_id
 * @property string|null $autor_name
 * @property string $tipo
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reacao whereAutorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reacao whereAutorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reacao whereComentarioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reacao whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reacao whereIdreacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reacao wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reacao whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reacao whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reacao whereType($value)
 */
class Reacao extends Model
{
    protected $primaryKey = 'idreacao';
    protected $table = 'reacao';
}
