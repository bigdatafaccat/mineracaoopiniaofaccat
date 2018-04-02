import psycopg2
from time import gmtime, strftime
from unicodedata import normalize
import nltk
import math
from time import gmtime, strftime
import sys 
import os
sys.path.append(os.path.abspath("../"))
from conexao import *


def pre_process_sentences():
	
	#atualiza campo com dia da postagem
	sql = "update sentenca set post_dia = extract(day from post_datahora::date), tamanho_sentenca_texto = length(texto), tamanho_post_texto = length(post_texto), tamanho_comentario_texto = length(comentario_texto), tamanho_comentario_comentario_texto = length(comentario_comentario_texto)"
	cur.execute(sql)
	
	
	

if __name__ == '__main__':
	
	
	inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
	
	pre_process_sentences()
	
	conn.commit()
	cur.close()
	conn.close()
	fim = strftime("%Y-%m-%d %H:%M:%S", gmtime())
	print("Inicio "+inicio+" fim "+fim)
