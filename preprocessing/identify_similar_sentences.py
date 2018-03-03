import psycopg2
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from time import gmtime, strftime

try:
    conn = psycopg2.connect("dbname='anotacao' user='leonardo' host='localhost' password='leonardo'")
except:
    print("I am unable to connect to the database")

cur = conn.cursor()
cur.execute("SELECT idsentenca,texto FROM sentenca where not similar_outra and post_datahora::date > '2017-01-01' and post_datahora::date <= '2017-12-31' order by texto")

result = cur.fetchall()

documents = []
idsentencas = []
sentencas_similares = []


for i in result:
    documents.append(i[1])
    idsentencas.append(i[0])

total = len(idsentencas)
print(total)

#documents = ['Essa casa', 'Esta casa', 'Esta semana', 'Semana', 'Essa', 'Esta']
indice_1 = 0
for i in documents:
    tfidf_vectorizer = TfidfVectorizer()
    tfidf_matrix = tfidf_vectorizer.fit_transform(documents)
    #print(tfidf_matrix.shape)

    similaridades = cosine_similarity(tfidf_matrix[indice_1], tfidf_matrix)
    #similaridades = cosine_similarity(tfidf_matrix, tfidf_matrix)
    indice_2 = 0
    #print(i)
    for similaridade in similaridades[0]:
        if (indice_1 != indice_2 and similaridade > 0.9):
            print("Frases "+str(idsentencas[indice_1])+" --- "+str(idsentencas[indice_2]))
            sentencas_similares.append(idsentencas[indice_1])
            cur.execute("update sentenca set similar_outra = true where idsentenca = "+str(idsentencas[indice_1]))
        indice_2 += 1
        

    indice_1 += 1
    print(str(indice_1 / len(idsentencas))+'%')
    print(strftime("%Y-%m-%d %H:%M:%S", gmtime()))

#print(documents)

cur.close()
conn.close()
