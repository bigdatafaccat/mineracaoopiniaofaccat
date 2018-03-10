import psycopg2
#import unidecode
from time import gmtime, strftime
from unicodedata import normalize
import nltk
import math
from time import gmtime, strftime


def normalizar(limite):
	cur.execute("select idpart_of_speech, trim(termo), length(trim(termo)) as tamanho from part_of_speech where trim(termo) <> '' and not termo_analisado limit "+str(limite))  #limpa termos antigos
	result = cur.fetchall()
	
	for registro in result:
		idpart_of_speech = registro[0]
		termo = registro[1].lower().rstrip()
		tamanho = registro[2]
		termo = termo.replace(',', '')
		termo = termo.replace('"', '')
		termo = termo.replace("'", '')
		termo = termo.replace(";", '')
		termo = termo.replace("/", '')
		termo = termo.replace("\\", '')
		termo = termo.replace("-", '')
		termo = termo.replace("_", '')
		termo = termo.replace("+", '')
		termo = termo.replace("=", '')
		termo = termo.replace("–", '')
		termo = termo.replace("(", '')
		termo = termo.replace(")", '')
		termo = termo.replace("[", '')
		termo = termo.replace("]", '')
		termo = termo.replace("{", '')
		termo = termo.replace("}", '')
		termo = termo.replace(":", '')
		termo = termo.replace("%", '')
		termo = termo.replace("#", '')
		termo = termo.replace("@", '')
		termo = termo.replace("*", '')
		termo = termo.replace("&", '')
		
		if len(termo) > 3:
			#print(termo, tamanho)
			termo_sem_acentuacao = normalize('NFKD', termo).encode('ASCII', 'ignore').decode('ASCII')
			stemmer = nltk.stem.RSLPStemmer()
			termo_com_stem = stemmer.stem(termo_sem_acentuacao)
			sql = "update part_of_speech set normalizado = true, termo_analisado = true, termo_sem_acentuacao = '"+termo_sem_acentuacao+"', termo_com_stem = '"+termo_com_stem+"' where idpart_of_speech = "+str(idpart_of_speech)
			cur.execute(sql)
		else:
			sql = "update part_of_speech set termo_analisado = true where idpart_of_speech = "+str(idpart_of_speech)
			cur.execute(sql)

if __name__ == '__main__':
	
	inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
	
	try:
		conn = psycopg2.connect("dbname='anotacao' user='leonardo' host='localhost' password='leonardo'")
	except:
		print("I am unable to connect to the database")
	
	cur = conn.cursor()
	
	cur.execute("select count(*) from part_of_speech where not termo_analisado")  #limpa termos antigos
	result = cur.fetchone()
	sentencas = result[0]
	#sentencas = 20000
	limite = 10000
	janelas = math.ceil(sentencas / limite)
	
	for janela in range(0, janelas):
		print("Janela: "+str(janela+1)+" de "+str(janelas))
		normalizar(limite)
		conn.commit()
		 
	
	conn.commit()
	cur.close()
	conn.close()
	fim = strftime("%Y-%m-%d %H:%M:%S", gmtime())
	print("Inicio "+inicio+" fim "+fim)
