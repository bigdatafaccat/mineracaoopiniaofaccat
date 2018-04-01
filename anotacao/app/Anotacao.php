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
 * @property bool|null $vale_paranhana
 * @property string|null $post_opiniao
 * @property bool|null $post_assunto_saude
 * @property bool|null $post_assunto_educacao
 * @property bool|null $post_assunto_seguranca
 * @property bool|null $post_assunto_meioambiente
 * @property bool|null $post_assunto_emprego
 * @property bool|null $post_assunto_politica
 * @property bool|null $post_assunto_naosei
 * @property bool|null $post_assunto_nenhum
 * @property string|null $post_assunto_outro
 * @property bool|null $post_sentimento_alegria
 * @property bool|null $post_sentimento_surpresa
 * @property bool|null $post_sentimento_medo
 * @property bool|null $post_sentimento_tristeza
 * @property bool|null $post_sentimento_raiva
 * @property bool|null $post_sentimento_repugnancia
 * @property bool|null $post_sentimento_confianca
 * @property bool|null $post_sentimento_expectativa
 * @property bool|null $post_sentimento_nenhum
 * @property bool|null $post_sentimento_naosei
 * @property string|null $post_sentimento_outro
 * @property string|null $comentario_opiniao
 * @property bool|null $comentario_assunto_saude
 * @property bool|null $comentario_assunto_educacao
 * @property bool|null $comentario_assunto_seguranca
 * @property bool|null $comentario_assunto_meioambiente
 * @property bool|null $comentario_assunto_emprego
 * @property bool|null $comentario_assunto_politica
 * @property bool|null $comentario_assunto_naosei
 * @property bool|null $comentario_assunto_nenhum
 * @property string|null $comentario_assunto_outro
 * @property bool|null $comentario_sentimento_alegria
 * @property bool|null $comentario_sentimento_surpresa
 * @property bool|null $comentario_sentimento_medo
 * @property bool|null $comentario_sentimento_tristeza
 * @property bool|null $comentario_sentimento_raiva
 * @property bool|null $comentario_sentimento_repugnancia
 * @property bool|null $comentario_sentimento_confianca
 * @property bool|null $comentario_sentimento_expectativa
 * @property bool|null $comentario_sentimento_nenhum
 * @property bool|null $comentario_sentimento_naosei
 * @property string|null $comentario_sentimento_outro
 * @property string|null $comentario_comentario_opiniao
 * @property bool|null $comentario_comentario_assunto_saude
 * @property bool|null $comentario_comentario_assunto_educacao
 * @property bool|null $comentario_comentario_assunto_seguranca
 * @property bool|null $comentario_comentario_assunto_meioambiente
 * @property bool|null $comentario_comentario_assunto_emprego
 * @property bool|null $comentario_comentario_assunto_politica
 * @property bool|null $comentario_comentario_assunto_naosei
 * @property bool|null $comentario_comentario_assunto_nenhum
 * @property string|null $comentario_comentario_assunto_outro
 * @property bool|null $comentario_comentario_sentimento_alegria
 * @property bool|null $comentario_comentario_sentimento_surpresa
 * @property bool|null $comentario_comentario_sentimento_medo
 * @property bool|null $comentario_comentario_sentimento_tristeza
 * @property bool|null $comentario_comentario_sentimento_raiva
 * @property bool|null $comentario_comentario_sentimento_repugnancia
 * @property bool|null $comentario_comentario_sentimento_confianca
 * @property bool|null $comentario_comentario_sentimento_expectativa
 * @property bool|null $comentario_comentario_sentimento_nenhum
 * @property bool|null $comentario_comentario_sentimento_naosei
 * @property string|null $comentario_comentario_sentimento_outro
 * @property string|null $sentenca_opiniao
 * @property bool|null $sentenca_assunto_saude
 * @property bool|null $sentenca_assunto_educacao
 * @property bool|null $sentenca_assunto_seguranca
 * @property bool|null $sentenca_assunto_meioambiente
 * @property bool|null $sentenca_assunto_emprego
 * @property bool|null $sentenca_assunto_politica
 * @property bool|null $sentenca_assunto_naosei
 * @property bool|null $sentenca_assunto_nenhum
 * @property string|null $sentenca_assunto_outro
 * @property bool|null $sentenca_sentimento_alegria
 * @property bool|null $sentenca_sentimento_surpresa
 * @property bool|null $sentenca_sentimento_medo
 * @property bool|null $sentenca_sentimento_tristeza
 * @property bool|null $sentenca_sentimento_raiva
 * @property bool|null $sentenca_sentimento_repugnancia
 * @property bool|null $sentenca_sentimento_confianca
 * @property bool|null $sentenca_sentimento_expectativa
 * @property bool|null $sentenca_sentimento_nenhum
 * @property bool|null $sentenca_sentimento_naosei
 * @property string|null $sentenca_sentimento_outro
 * @property bool|null $assunto_transito
 * @property bool|null $post_assunto_transito
 * @property bool|null $comentario_assunto_transito
 * @property bool|null $comentario_comentario_assunto_transito
 * @property bool|null $assunto_economia
 * @property bool|null $post_assunto_economia
 * @property bool|null $comentario_assunto_economia
 * @property bool|null $comentario_comentario_assunto_economia
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereAssuntoEconomia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereAssuntoTransito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioAssuntoEconomia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioAssuntoEducacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioAssuntoEmprego($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioAssuntoMeioambiente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioAssuntoNaosei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioAssuntoNenhum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioAssuntoOutro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioAssuntoPolitica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioAssuntoSaude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioAssuntoSeguranca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioAssuntoTransito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioAssuntoEconomia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioAssuntoEducacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioAssuntoEmprego($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioAssuntoMeioambiente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioAssuntoNaosei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioAssuntoNenhum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioAssuntoOutro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioAssuntoPolitica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioAssuntoSaude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioAssuntoSeguranca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioAssuntoTransito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioOpiniao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioSentimentoAlegria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioSentimentoConfianca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioSentimentoExpectativa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioSentimentoMedo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioSentimentoNaosei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioSentimentoNenhum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioSentimentoOutro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioSentimentoRaiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioSentimentoRepugnancia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioSentimentoSurpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioComentarioSentimentoTristeza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioOpiniao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioSentimentoAlegria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioSentimentoConfianca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioSentimentoExpectativa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioSentimentoMedo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioSentimentoNaosei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioSentimentoNenhum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioSentimentoOutro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioSentimentoRaiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioSentimentoRepugnancia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioSentimentoSurpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereComentarioSentimentoTristeza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostAssuntoEconomia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostAssuntoEducacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostAssuntoEmprego($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostAssuntoMeioambiente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostAssuntoNaosei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostAssuntoNenhum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostAssuntoOutro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostAssuntoPolitica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostAssuntoSaude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostAssuntoSeguranca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostAssuntoTransito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostOpiniao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostSentimentoAlegria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostSentimentoConfianca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostSentimentoExpectativa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostSentimentoMedo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostSentimentoNaosei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostSentimentoNenhum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostSentimentoOutro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostSentimentoRaiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostSentimentoRepugnancia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostSentimentoSurpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao wherePostSentimentoTristeza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaAssuntoEducacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaAssuntoEmprego($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaAssuntoMeioambiente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaAssuntoNaosei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaAssuntoNenhum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaAssuntoOutro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaAssuntoPolitica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaAssuntoSaude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaAssuntoSeguranca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaOpiniao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaSentimentoAlegria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaSentimentoConfianca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaSentimentoExpectativa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaSentimentoMedo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaSentimentoNaosei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaSentimentoNenhum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaSentimentoOutro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaSentimentoRaiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaSentimentoRepugnancia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaSentimentoSurpresa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereSentencaSentimentoTristeza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Anotacao whereValeParanhana($value)
 */
class Anotacao extends Model
{
    protected $primaryKey = 'idanotacao';
    protected $table = 'anotacao';
}
