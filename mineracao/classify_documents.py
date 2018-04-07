#http://scikit-learn.org/stable/tutorial/text_analytics/working_with_text_data.html


from time import gmtime, strftime
import sys 
import os
from unicodedata import normalize
sys.path.append(os.path.abspath("../"))
from conexao import *

# Natural Language Processing

# Importing the libraries
import numpy as np
import matplotlib.pyplot as plt
import pandas as pd
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.feature_extraction.text import TfidfTransformer
from sklearn.naive_bayes import MultinomialNB
import re
import nltk
#nltk.download('stopwords')
from nltk.corpus import stopwords

# Importing the dataset
#dataset = pd.read_csv('Restaurant_Reviews.tsv', delimiter = '\t', quoting = 3)
conn = psycopg2.connect(string_conexao)
cur = conn.cursor()
sql = "select s.texto, case when d.variavel_dependente = 'positiva' then 1 else 0 end as variavel_dependente from documento_para_treino d inner join sentenca s using (idsentenca) where d.variavel_dependente in ('positiva', 'negativa')"
cur.execute(sql)

dataset = pd.DataFrame(cur.fetchall(), columns=['texto', 'variavel_dependente'])

cur.close()
conn.close()

# Cleaning the texts

corpus = []
stopwords_portuguese = stopwords.words('portuguese')
stemmer = nltk.stem.RSLPStemmer()

for i in range(0, len(dataset)):
    tmp = []
    
    texto = dataset['texto'][i]
    texto = texto.rstrip()
    texto = texto.lower()
    texto = normalize('NFKD', texto).encode('ASCII', 'ignore').decode('ASCII')
    texto = re.sub('[^a-zA-Z]', ' ', texto)
    
    termos = texto.split()
    for termo in termos:
        if (termo not in stopwords_portuguese):
            tmp.append(stemmer.stem(termo))
    
    corpus.append(' '.join(tmp))


# Creating the Bag of Words model
from sklearn.feature_extraction.text import CountVectorizer
#cv = CountVectorizer(max_features = 150000)
cv = CountVectorizer()
X = cv.fit_transform(corpus).toarray()
y = dataset.iloc[:, 1].values



# Splitting the dataset into the Training set and Test set
from sklearn.cross_validation import train_test_split
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.5, random_state = 0)
#X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.2)

#NAIVE BAYES
# Fitting Naive Bayes to the Training set
from sklearn.naive_bayes import GaussianNB
#classifier = GaussianNB()
#classifier.fit(X_train, y_train)


#SVM
from sklearn.svm import SVC
classifier = SVC(kernel = 'linear', random_state = 0)
#classifier = SVC(kernel = 'rbf', random_state = 0)
#classifier = SVC(kernel = 'linear')
classifier.fit(X_train, y_train)


#RANDOM TREE
# Feature Scaling
from sklearn.preprocessing import StandardScaler
sc = StandardScaler()
X_train = sc.fit_transform(X_train)
X_test = sc.transform(X_test)

# Fitting Decision Tree Classification to the Training set
from sklearn.tree import DecisionTreeClassifier
classifier = DecisionTreeClassifier(criterion = 'entropy', random_state = 0)
classifier.fit(X_train, y_train)




# Predicting the Test set results
y_pred = classifier.predict(X_test)

# Making the Confusion Matrix
from sklearn.metrics import confusion_matrix
from sklearn import metrics


#metrics.classification_report(y_test, y_pred, target_names=twenty_test.target_names)
resultado = metrics.classification_report(y_test, y_pred)
cm = confusion_matrix(y_test, y_pred)

print (resultado)