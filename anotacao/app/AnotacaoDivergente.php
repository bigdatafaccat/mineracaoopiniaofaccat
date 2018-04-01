<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AnotacaoDivergente
 *
 * @property int $idanotacao_divergente
 * @property int $idsentenca
 * @property string $tipo
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnotacaoDivergente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnotacaoDivergente whereIdanotacaoDivergente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnotacaoDivergente whereIdsentenca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnotacaoDivergente whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AnotacaoDivergente whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AnotacaoDivergente extends Model
{
    protected $primaryKey = 'idanotacao_divergente';
    protected $table = 'anotacao_divergente';
}
