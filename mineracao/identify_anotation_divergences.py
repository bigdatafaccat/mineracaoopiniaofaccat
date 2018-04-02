from time import gmtime, strftime
from unicodedata import normalize
import math
from time import gmtime, strftime
import sys 
import os
sys.path.append(os.path.abspath("../"))
from conexao import *


def analisar_anotacao_de_opiniao():
	cur.execute("select idsentenca, count(*) as anotacoes, count(distinct(coalesce(opiniao, '0'))) as opinioes_diferentes, mode() WITHIN GROUP (ORDER BY opiniao) AS moda from anotacao group by 1 order by 1")
	result = cur.fetchall()
	for registro in result:
		idsentenca = registro[0]
		anotacoes = registro[1]
		anotacoes_diferentes = registro[2]
		moda = registro[3] #valor que mais se repete
		
		if (anotacoes >= 2 and (((anotacoes - anotacoes_diferentes) == 0))):
			#precisa reanotar
			cur.execute("insert into anotacao_divergente (idsentenca, tipo) values ("+str(idsentenca)+", 'opiniao')")
			
			
		elif (anotacoes >= 2 and ((anotacoes - anotacoes_diferentes) > 0)):
			#então pode considerar sentenca para treino
			cur.execute("insert into documento_para_treino (idsentenca, tipo, variavel_dependente) values ("+str(idsentenca)+", 'opiniao', '"+str(moda)+"')")
		

def analisar_anotacao_de_assuntos():
	assuntos = ['saude', 'educacao', 'seguranca']
	for assunto in assuntos:
		analisar_anotacao_de_assunto(assunto)	

def analisar_anotacao_de_assunto(assunto):
	q = "select idsentenca, count(*) as anotacoes, count(distinct(coalesce(assunto_"+assunto+", '0'))) as anotacoes_diferentes, mode() WITHIN GROUP (ORDER BY assunto_"+assunto+") AS moda from anotacao group by 1 order by 1"
	cur.execute(q)
	result = cur.fetchall()
	for registro in result:
		idsentenca = registro[0]
		anotacoes = registro[1]
		anotacoes_diferentes = registro[2]
		moda = registro[3] #valor que mais se repete
		
		menciona_assunto = ''
		if (moda):
			menciona_assunto = assunto
		
		
		if (anotacoes >= 2 and (((anotacoes - anotacoes_diferentes) == 0))):
			#precisa reanotar
			cur.execute("insert into anotacao_divergente (idsentenca, tipo) values ("+str(idsentenca)+", 'assunto')")
			
		elif (anotacoes >= 2 and ((anotacoes - anotacoes_diferentes) > 0) and moda):
			#então pode considerar sentenca para treino
			cur.execute("insert into documento_para_treino (idsentenca, tipo, variavel_dependente) values ("+str(idsentenca)+", 'assunto', '"+str(menciona_assunto)+"')")
			
			
			
					

if __name__ == '__main__':
	
	
	inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
	
	cur = conn.cursor()
	#limpa tabela com anotacoes divergentes
	cur.execute("truncate anotacao_divergente")
	#limpa tabela com documentos para treino
	cur.execute("truncate documento_para_treino")
	
	analisar_anotacao_de_opiniao()
	analisar_anotacao_de_assuntos()
	  
	
		 
	
	conn.commit()
	cur.close()
	conn.close()
	fim = strftime("%Y-%m-%d %H:%M:%S", gmtime())
	print("Inicio "+inicio+" fim "+fim)
