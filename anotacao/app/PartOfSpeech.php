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
 */
class PartOfSpeech extends Model
{
    protected $primaryKey = 'idpart_of_speech';
    protected $table = 'part_of_speech';
}
