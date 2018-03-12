import psycopg2
from time import gmtime, strftime
from unicodedata import normalize
import nltk
import math
from time import gmtime, strftime


def pre_process_sentences():
	
	#atualiza campo com dia da postagem
	sql = "update sentenca set post_dia = extract(day from post_datahora::date)"
	cur.execute(sql)
	
	
	

if __name__ == '__main__':
	
	
	inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
	
	try:
		conn = psycopg2.connect("dbname='anotacao' user='leonardo' host='localhost' password='leonardo'")
	except:
		print("I am unable to connect to the database")

	pre_process_sentences()
	
	conn.commit()
	cur.close()
	conn.close()
	fim = strftime("%Y-%m-%d %H:%M:%S", gmtime())
	print("Inicio "+inicio+" fim "+fim)
