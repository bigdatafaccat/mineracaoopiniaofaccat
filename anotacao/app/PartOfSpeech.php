<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PartOfSpeech
 *
 * @property int $idpart_of_speech
 * @property int $idsentenca
 * @property string $termo
 * @property string $pos
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech whereIdpartOfSpeech($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech whereIdsentenca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech whereTermo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $termo_sem_acentuacao
 * @property string|null $termo_com_stem
 * @property bool|null $normalizado
 * @property bool|null $termo_analisado
 * @property bool|null $pre_aspecto_saude
 * @property bool|null $pre_aspecto_educacao
 * @property bool|null $pre_aspecto_seguranca
 * @property bool|null $pre_aspecto_analisado
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech whereNormalizado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech wherePreAspectoAnalisado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech wherePreAspectoEducacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech wherePreAspectoSaude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech wherePreAspectoSeguranca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech whereTermoAnalisado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech whereTermoComStem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PartOfSpeech whereTermoSemAcentuacao($value)
 */
class PartOfSpeech extends Model
{
    protected $primaryKey = 'idpart_of_speech';
    protected $table = 'part_of_speech';
}
