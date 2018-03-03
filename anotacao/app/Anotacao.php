<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Anotacao
 *
 * @property int $idanotacao
 * @property int $idsentenca
 * @property int $idusuario
 * @property string|null $opiniao
 * @property bool|null $assunto_saude
 * @property bool|null $assunto_educacao
 * @property bool|null $assunto_seguranca
 * @property bool|null $assunto_meioambiente
 * @property bool|null $assunto_emprego
 * @property bool|null $assunto_politica
 * @property bool|null $assunto_naosei
 * @property bool|null $assunto_nenhum
 * @property string|null $assunto_outro
 * @property bool|null $sentimento_alegria
 * @property bool|null $sentimento_surpresa
 * @property bool|null $sentimento_medo
 * @property bool|null $sentimento_tristeza
 * @property bool|null $sentimento_raiva
 * @property bool|null $sentimento_repugnancia
 * @property bool|null $sentimento_confianca
 * @property bool|null $sentimento_expectativa
 * @property bool|null $sentimento_nenhum
 * @property bool|null $sentimento_naosei
 * @property string|null $sentimento_outro
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereAssuntoEducacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereAssuntoEmprego($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereAssuntoMeioambiente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereAssuntoNaosei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereAssuntoNenhum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereAssuntoOutro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereAssuntoPolitica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereAssuntoSaude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereAssuntoSeguranca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereIdanotacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereIdsentenca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereOpiniao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentimentoAlegria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentimentoConfianca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentimentoExpectativa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentimentoMedo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentimentoNaosei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentimentoNenhum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentimentoOutro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentimentoRaiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentimentoRepugnancia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentimentoSurpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentimentoTristeza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool|null $pular
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePular($value)
 */
class Anotacao extends Model
{
    protected $primaryKey = 'idanotacao';
    protected $table = 'anotacao';
}
