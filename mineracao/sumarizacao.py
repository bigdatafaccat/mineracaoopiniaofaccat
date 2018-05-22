#http://scikit-learn.org/stable/tutorial/text_analytics/working_with_text_data.html
#https://stackoverflow.com/questions/28384680/scikit-learns-pipeline-a-sparse-matrix-was-passed-but-dense-data-is-required
#http://zacstewart.com/2014/08/05/pipelines-of-featureunions-of-pipelines.html


from time import gmtime, strftime
import sys 
import os
import time
from unicodedata import normalize


# Natural Language Processing

# Importing the libraries
import numpy as np
import matplotlib.pyplot as plt
import pandas as pd
import gc
import warnings
import json

class Sumarizacao(object):
    conexao = None
    
    def recriar_resumo_geral(self, algoritmo, lote):
        sql = """
        
        drop table if exists resumo_final;
        create table resumo_final  (
            idresumo_final bigserial,
            post_id varchar(255),
            comentario_id varchar(255),
            comentario_comentario_id varchar(255),
            tipo_texto text,
            assunto text,
            sentencas_positivas int,
            sentencas_negativas int,
            vale_paranhana boolean,
            autor varchar(255), 
            grupo_id varchar(255),
            post_datahora date
        ); 
        
        
        drop table if exists resumo_termos;
        create table resumo_termos (
            idresumo_termos bigserial,
            post_id varchar(255),
            comentario_id varchar(255),
            comentario_comentario_id varchar(255),
            sentenca_id varchar(255),
            termo text,
            assunto text
        ); 
        
        
        drop table if exists resumo;
        create table resumo as (
          select d.* 
            from documento_classificado d
      inner join experimentos_avaliacao_resultado e on (e.idexperimentos_avaliacao_resultado = d.idexperimentos_avaliacao_resultado)
           where e.algoritmo = %s
             and e.lote_numero = %s
        );
        
        update resumo set comentario_id = '' where comentario_id = 'None';
        update resumo set comentario_comentario_id = '' where comentario_comentario_id = 'None';
        
        drop index if exists idxsentencaanotada3;
        drop index if exists idxsentencaanotada2;
        drop index if exists idxsentencaanotada1;
        drop index if exists idxsentencaanotada0;
        drop index if exists idxsentencaanotadaex;
        
        
        create index idxsentencaanotada3 on resumo (post_id, comentario_id, comentario_comentario_id);
        create index idxsentencaanotada2 on resumo (post_id, comentario_id, comentario_comentario_id, sentenca_id);
        create index idxsentencaanotada1 on resumo (post_id, comentario_id, comentario_comentario_id, sentenca_id, oqueclassifica, variavel_dependente) where variavel_dependente = '1';
        create index idxsentencaanotada0 on resumo (post_id, comentario_id, comentario_comentario_id, sentenca_id, oqueclassifica, variavel_dependente) where variavel_dependente = '0';
        create index idxsentencaanotadaex on resumo (idexperimentos_avaliacao_resultado);
        
        """
        parametros = (
                str(algoritmo),
                str(lote)
        )
        self.conexao.executar(sql, parametros)
        
        
    def reiniciar_resumo_opiniao(self):
        sql = """
        drop table if exists resumo_opiniao;
        create table resumo_opiniao as 
        (
        select d.post_id,
               d.comentario_id,
               d.comentario_comentario_id,
               d1.sentenca_id,
               d.tipo_texto,
               d.idexperimentos_avaliacao_resultado,
               d.variavel_dependente
          from resumo d
    inner join resumo d1 on (d1.post_id = d.post_id and 
                             coalesce(d1.comentario_id, '') = coalesce(d.comentario_id, '') and 
                             coalesce(d1.comentario_comentario_id, '') = coalesce(d.comentario_comentario_id, '') and 
                             coalesce(d1.sentenca_id, '') = coalesce(d.sentenca_id, '') and 
                             d1.variavel_dependente = '1' and
                             d1.oqueclassifica = 'com_sem_opiniao')
         where d.oqueclassifica = 'opiniao'
        );
        create index resumoopiniaoix on resumo_opiniao (post_id, comentario_id, comentario_comentario_id, sentenca_id, variavel_dependente);           
        create index resumoopiniaoix2 on resumo_opiniao (post_id, comentario_id, comentario_comentario_id, variavel_dependente);           
        """
        parametros = (
        )
        self.conexao.executar(sql, parametros)
    
    def reiniciar_resumo(self, assunto):
        sql = """
        insert into resumo_final (
        post_id, comentario_id, comentario_comentario_id, tipo_texto, assunto, sentencas_positivas, sentencas_negativas, vale_paranhana, autor, grupo_id, post_datahora
        ) (select * 
        from  
        (
        select d.post_id,
               d.comentario_id,
               d.comentario_comentario_id,
               d.tipo_texto,
               %s as assunto,
               (select count(*)
                  from resumo_opiniao d1 
                 where d.post_id = d1.post_id 
                   and coalesce(d.comentario_id, '') = coalesce(d1.comentario_id, '')
                   and coalesce(d.comentario_comentario_id, '') = coalesce(d1.comentario_comentario_id, '')
                   and d1.variavel_dependente = '1'
                   ) as sentencas_positivas,
               (select count(*)
                  from resumo_opiniao d2 
                 where d.post_id = d2.post_id 
                   and coalesce(d.comentario_id, '') = coalesce(d2.comentario_id, '')
                   and coalesce(d.comentario_comentario_id, '') = coalesce(d2.comentario_comentario_id, '')
                   and d2.variavel_dependente = '0'
                   ) as sentencas_negativas,
               case when d3.post_id is null then false else true end as vale_paranhana,
               case 
                   when d.tipo_texto = 'post' then s.post_autor_id
                   when d.tipo_texto = 'comentario' then s.comentario_autor_id
                   when d.tipo_texto = 'comentario_de_comentario' then s.comentario_comentario_autor_id
               end as autor,
               s.grupo_id,
               s.post_datahora::date as post_datahora
               
          from resumo d
     left join resumo d3 on (d3.post_id = d.post_id and 
                             coalesce(d3.comentario_id, '') = coalesce(d.comentario_id, '') and 
                             coalesce(d3.comentario_comentario_id, '') = coalesce(d.comentario_comentario_id, '') and 
                             d3.variavel_dependente = '1' and
                             d3.oqueclassifica = 'vale_paranhana')
     inner join sentenca s on (s.post_id = d.post_id and 
                              coalesce(s.comentario_id, '') = coalesce(d.comentario_id, '') and 
                              coalesce(s.comentario_comentario_id, '') = coalesce(d.comentario_comentario_id, ''))
         where d.oqueclassifica = %s
           and d.variavel_dependente = '1'
           and s.post_datahora::date > '2017-01-01' and s.post_datahora::date < '2017-07-01'
           group by 1,2,3,4,5,6,7,8,9,10,11
        ) a)
        """
        parametros = (
                str(assunto),
                str(assunto)
        )
        self.conexao.executar(sql, parametros)
        
        
    def reiniciar_termos(self, assunto):
        
        sql = """
        insert into resumo_termos (post_id, comentario_id, comentario_comentario_id, sentenca_id, termo, assunto) (select * 
        from  
        (
        select s.post_id,
               s.comentario_id,
               s.comentario_comentario_id,
               s.sentenca_id,
               replace(lower(p.termo), ',', '') as termo,
               f.assunto as assunto
          from resumo_final f
          
    inner join sentenca s on (s.post_id = f.post_id and 
                              coalesce(s.comentario_id, '') = coalesce(f.comentario_id, '') and 
                              coalesce(s.comentario_comentario_id, '') = coalesce(f.comentario_comentario_id, ''))
      inner join part_of_speech p on (p.idsentenca = s.idsentenca)      
          
         where p.pos = %s
           and f.assunto = %s
           and p.normalizado
           and s.post_datahora::date > '2017-01-01' and s.post_datahora::date < '2017-07-01'
        ) a)
        """
        parametros = (
                'NOUN',
                str(assunto)
        )
        self.conexao.executar(sql, parametros)
    

def main():
    inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
    print("Início do script")
    print(inicio)
    sys.path.append(os.path.abspath("../"))
    from conexao import Conexao
    lote = 6
    algoritmo = 'SVM'
    
    
    sumarizacao = Sumarizacao()    
    sumarizacao.conexao = Conexao()
    
    
    print("Recriando resumo geral "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
    sumarizacao.recriar_resumo_geral(algoritmo, lote)
    print("Resumo geral recriado "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
    
    print("Recriando resumo de opinião "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
    sumarizacao.reiniciar_resumo_opiniao()
    print("Resumo de opinião recriado "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
    
    
    assuntos = ['saude', 'seguranca', 'educacao']
    #assuntos = ['educacao']
    for assunto in assuntos:
        print("Início de resumo de "+assunto+" "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
        sumarizacao.reiniciar_resumo(assunto)
        print("Resumo de termos "+assunto+" "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
        sumarizacao.reiniciar_termos(assunto)
        print("Fim de resumo de "+assunto+" "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
    
    print("Início do script")
    print(inicio)
    print("Fim do script")
    fim = strftime("%Y-%m-%d %H:%M:%S", gmtime())
    print(fim)
    
    
    
if __name__ == "__main__":
    os.environ['TZ'] = 'America/Sao_Paulo'
    time.tzset()
    warnings.filterwarnings("ignore")
    main()