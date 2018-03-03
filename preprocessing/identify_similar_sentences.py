import psycopg2
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from time import gmtime, strftime

try:
    conn = psycopg2.connect("dbname='anotacao' user='leonardo' host='localhost' password='leonardo'")
except:
    print("I am unable to connect to the database")

cur = conn.cursor()

print("Início do script")
print(strftime("%Y-%m-%d %H:%M:%S", gmtime()))

#cur.execute("create temp table tmp as (select count(x.*), array_agg(x.idsentenca) as idsentenca from sentenca x group by texto having count(*) > 1)")
print("Criada tabela temporária tmp")
print(strftime("%Y-%m-%d %H:%M:%S", gmtime()))

#cur.execute("create temp table sentencas_duplicadas as (select * from sentenca where idsentenca in (select unnest(idsentenca) from tmp))")
print("Criada tabela temporária sentencas_duplicadas")
print(strftime("%Y-%m-%d %H:%M:%S", gmtime()))

#cur.execute("update sentenca set similar_outra = true where similar_outra = false and idsentenca in (select idsentenca from sentencas_duplicadas)")
print("Sentenças duplicadas identificadas")
print(strftime("%Y-%m-%d %H:%M:%S", gmtime()))

cur.execute("SELECT idsentenca,texto FROM sentenca where not similar_outra and not similaridade_analisada and post_datahora::date > '2017-01-01' and post_datahora::date <= '2017-12-31' order by texto limit 10000")

result = cur.fetchall()
conn.commit()

documents = []
idsentencas = []
sentencas_similares = []


for i in result:
    documents.append(i[1])
    idsentencas.append(i[0])

total = len(idsentencas)
print(total)

print("fim similaridades")

#documents = ['Essa casa', 'Esta casa', 'Esta semana', 'Semana', 'Essa', 'Esta']

cur = conn.cursor()
indice_1 = 0
for i in documents:
    tfidf_vectorizer = TfidfVectorizer()
    tfidf_matrix = tfidf_vectorizer.fit_transform(documents)
    #print(tfidf_matrix.shape)

    #documentação em http://scikit-learn.org/stable/modules/metrics.html#cosine-similarity
    similaridades = cosine_similarity(tfidf_matrix[indice_1], tfidf_matrix)
    #similaridades = cosine_similarity(tfidf_matrix, tfidf_matrix)
    indice_2 = 0
    #print(i)
    for similaridade in similaridades[0]:
        if (indice_1 != indice_2 and similaridade > 0.9):
            print("Frases "+str(idsentencas[indice_1])+" --- "+str(idsentencas[indice_2]))
            sentencas_similares.append(idsentencas[indice_1])
            cur.execute("update sentenca set similar_outra = true, similaridade_analisada = true where idsentenca = "+str(idsentencas[indice_1]))
            cur.execute("insert into similaridade (idsentenca1, idsentenca2, cosine_similarity) values ("+str(idsentencas[indice_1])+", "+str(idsentencas[indice_2])+", "+str(similaridade)+")")


        indice_2 += 1
        
    cur.execute("update sentenca set similaridade_analisada = true where idsentenca = "+str(idsentencas[indice_1]))
    indice_1 += 1
    print(str(indice_1 / len(idsentencas) * 100)+'%')
    print(strftime("%Y-%m-%d %H:%M:%S", gmtime()))

#print(documents)

conn.commit()
cur.close()
conn.close()
