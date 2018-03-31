import psycopg2
#import unidecode
from time import gmtime, strftime
from unicodedata import normalize
import nltk

try:
    conn = psycopg2.connect("dbname='anotacao' user='leonardo' host='localhost' password='leonardo'")
except:
    print("I am unable to connect to the database")

cur = conn.cursor()

word_lists = ['seguranca', 'saude', 'educacao']


cur.execute("truncate termo")  #limpa termos antigos
for aspecto in word_lists:
    file_object = open('word-list/'+aspecto+'.txt', 'r')
    words = file_object.readlines()
    for word in words:
        termo = word.rstrip()
        termo_sem_acento = normalize('NFKD', termo).encode('ASCII', 'ignore').decode('ASCII')
        
        stemmer = nltk.stem.RSLPStemmer()
        termo_com_stem = stemmer.stem(termo_sem_acento)
        sql =  "insert into termo (termo, termo_sem_acentuacao, aspecto, termo_stemming) values ('"+str(termo)+"', '"+str(termo_sem_acento)+"', '"+str(aspecto)+"', '"+str(termo_com_stem)+"')"
        cur.execute(sql)


conn.commit()
cur.close()
conn.close()
