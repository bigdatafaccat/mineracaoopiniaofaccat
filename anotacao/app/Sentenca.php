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
 * @property string|null $comentario_id
 * @property int|null $comentario_sentenca_id
 * @property string|null $tipo_texto
 * @property string $post_texto
 * @property string|null $comentario_texto
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereComentarioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereComentarioSentencaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereComentarioTexto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca wherePostTexto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereTipoTexto($value)
 * @property string|null $post_datahora
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca wherePostDatahora($value)
 * @property int|null $comentario_comentario_id
 * @property int|null $comentario_comentario_sentenca_id
 * @property string|null $comentario_comentario_texto
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereComentarioComentarioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereComentarioComentarioSentencaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereComentarioComentarioTexto($value)
 * @property string|null $post_autor_id
 * @property string|null $post_autor_name
 * @property string|null $comentario_autor_id
 * @property string|null $comentario_autor_name
 * @property string|null $comentario_comentario_autor_id
 * @property string|null $comentario_comentario_autor_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereComentarioAutorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereComentarioAutorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereComentarioComentarioAutorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereComentarioComentarioAutorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca wherePostAutorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca wherePostAutorName($value)
 * @property bool|null $similaroutra
 * @property bool|null $similar_outra
 * @property bool|null $similaridade_analisada
 * @property bool|null $pre_aspecto_saude
 * @property bool|null $pre_aspecto_educacao
 * @property bool|null $pre_aspecto_seguranca
 * @property int|null $post_dia
 * @property int|null $tamanho_sentenca_texto
 * @property int|null $tamanho_comentario_texto
 * @property int|null $tamanho_post_texto
 * @property int|null $tamanho_comentario_comentario_texto
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca wherePostDia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca wherePreAspectoEducacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca wherePreAspectoSaude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca wherePreAspectoSeguranca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereSimilaridadeAnalisada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereSimilaroutra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereTamanhoComentarioComentarioTexto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereTamanhoComentarioTexto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereTamanhoPostTexto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sentenca whereTamanhoSentencaTexto($value)
 */
class Sentenca extends Model
{
    protected $primaryKey = 'idsentenca';
    protected $table = 'sentenca';
}
