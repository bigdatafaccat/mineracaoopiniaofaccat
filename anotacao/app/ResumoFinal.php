<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResumoFinal extends Model
{
    protected $primaryKey = 'idresumo_final';
    protected $table = 'resumo_final';

    public static function obterResumoFinal($assunto) {
        $sql = "
            select count(a.idresumo_final) as qtd,
                   sum(a.qtdpositivas) as qtdpositivas, 
                   sum(a.qtdnegativas) as qtdnegativas
                   
              from (

            select idresumo_final,
                   case when sentencas_positivas > 0 then 1 else 0 end as qtdpositivas,
                   case when sentencas_negativas > 0 then 1 else 0 end as qtdnegativas 
              from resumo_final
             where assunto = ?
               and vale_paranhana) a
          
        ";

        $dados = \DB::select($sql, [$assunto]);
        return $dados;
    }

    public static function obterResumoTermos($assunto) {
        $sql = "
            select count(distinct idresumo_termos) as qtd,
                   termo 
              from resumo_termos
             where assunto = ?
               and trim(termo) <> ''
             group by termo
             order by 1 desc
             limit 100
        ";

        $dados = \DB::select($sql, [$assunto]);
        return $dados;
    }
}
