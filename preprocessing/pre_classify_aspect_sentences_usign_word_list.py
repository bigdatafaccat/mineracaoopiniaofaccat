import psycopg2
from time import gmtime, strftime
from unicodedata import normalize
import nltk
import math
from time import gmtime, strftime


def pre_classificar_termo(termo, aspecto):
	
	trecho_sql_update = 'pre_aspecto_'+aspecto+' = true'
	#atualiza tabela part_of_speech
	sql = "update part_of_speech set pre_aspecto_analisado = true, "+trecho_sql_update+" where normalizado and termo_com_stem = '"+str(termo)+"'"
	cur.execute(sql)
	
	#atualiza tabela sentenca
	sql = "update sentenca set "+trecho_sql_update+" where idsentenca in (select x.idsentenca from part_of_speech x where x.termo_com_stem = '"+str(termo)+"')"
	cur.execute(sql)
	
	

if __name__ == '__main__':
	
	
	inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
	
	try:
		conn = psycopg2.connect("dbname='anotacao' user='leonardo' host='localhost' password='leonardo'")
	except:
		print("I am unable to connect to the database")
	
	cur = conn.cursor()
	
	cur.execute("select distinct termo_stemming, aspecto from termo order by 1")
	result = cur.fetchall()
	total = len(result)
	contador = 1
	for registro in result:
		parcial = strftime("%Y-%m-%d %H:%M:%S", gmtime())	
		termo = registro[0]
		aspecto = registro[1]
		print(termo, aspecto, contador, total, parcial)
		pre_classificar_termo(termo, aspecto)
		conn.commit()
		contador += 1
		
	
	conn.commit()
	cur.close()
	conn.close()
	fim = strftime("%Y-%m-%d %H:%M:%S", gmtime())
	print("Inicio "+inicio+" fim "+fim)
