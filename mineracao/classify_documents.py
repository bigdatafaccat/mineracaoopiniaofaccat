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
from sklearn.metrics import confusion_matrix
from sklearn import metrics
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.feature_extraction.text import TfidfTransformer
from sklearn.naive_bayes import MultinomialNB
import re
import nltk
#nltk.download('stopwords')
from nltk.corpus import stopwords

#Não apresenta mensagens de warning
import warnings
warnings.filterwarnings("ignore")


def feature_scaling(X_train, X_test):
    # Feature Scaling
    from sklearn.preprocessing import StandardScaler
    sc = StandardScaler()
    X_train = sc.fit_transform(X_train)
    X_test = sc.transform(X_test)
    return [X_train, X_test]

def naive(X_train, y_train, X_test, y_test, realizar_scaling = False):
    print("")
    print("")
    print("Naive Bayes")
    
    if (realizar_scaling):
        print("Com feature scaling")
        X_train, X_test = feature_scaling(X_train, X_test)
    
    #NAIVE BAYES
    # Fitting Naive Bayes to the Training set
    from sklearn.naive_bayes import GaussianNB
    classifier = GaussianNB()
    classifier.fit(X_train, y_train)
    y_pred = classifier.predict(X_test)
    
    avaliar(y_test, y_pred)
    cross_fold(X_train, y_train, X_test, classifier)
    return y_pred


def svm(X_train, y_train, X_test, y_test, realizar_scaling = False):
    print("")
    print("")
    print("SVM")
    
    if (realizar_scaling):
        print("Com feature scaling")
        X_train, X_test = feature_scaling(X_train, X_test)
        
    #SVM
    from sklearn.svm import SVC
    classifier = SVC(kernel = 'linear', random_state = 0)
    #classifier = SVC(kernel = 'rbf', random_state = 0)
    #classifier = SVC(kernel = 'linear')
    classifier.fit(X_train, y_train)
    y_pred = classifier.predict(X_test)
    avaliar(y_test, y_pred)
    cross_fold(X_train, y_train, X_test, classifier)
    return y_pred

def xgboost(X_train, y_train, X_test, y_test, realizar_scaling = False):
    print("")
    print("")
    print("XGBoost")
    
    if (realizar_scaling):
        print("Com feature scaling")
        X_train, X_test = feature_scaling(X_train, X_test)
        
    #SVM
    from xgboost import XGBClassifier
    classifier = XGBClassifier()
    classifier.fit(X_train, y_train)
    y_pred = classifier.predict(X_test)
    avaliar(y_test, y_pred)
    cross_fold(X_train, y_train, X_test, classifier)
    return y_pred

def random_tree(X_train, y_train, X_test, y_test, realizar_scaling = False):
    print("")
    print("")
    print("Random tree")
    if (realizar_scaling):
        print("Com feature scaling")
        X_train, X_test = feature_scaling(X_train, X_test)
        
    #RANDOM TREE
    # Fitting Decision Tree Classification to the Training set
    from sklearn.tree import DecisionTreeClassifier
    classifier = DecisionTreeClassifier(criterion = 'entropy', random_state = 0)
    classifier.fit(X_train, y_train)
    y_pred = classifier.predict(X_test)
    avaliar(y_test, y_pred)
    cross_fold(X_train, y_train, X_test, classifier)
    return y_pred

def pipeline_SGDClassifier(corpus, y):
    X = corpus
    y = dataset.iloc[:, 1].values
                    
    from sklearn.cross_validation import train_test_split
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.2, random_state = 0)                
                    
    from sklearn.pipeline import Pipeline
    from sklearn.linear_model import SGDClassifier
    text_clf = Pipeline([('vect', CountVectorizer()),
                         ('tfidf', TfidfTransformer()),
                         ('clf', SGDClassifier(loss='hinge', penalty='l2',
                                               alpha=1e-3, random_state=0,
                                               n_iter=5, tol=None))])
                         
    text_clf.fit(X_train, y_train)  
    y_pred = text_clf.predict(X_test)
    avaliar(y_test, y_pred)
    cross_fold(X_train, y_train, X_test, text_clf)
    return y_pred

def pipeline_SGDClassifier_com_parametros_dinamicos(corpus, y):
    X = corpus
    y = dataset.iloc[:, 1].values
                    
    from sklearn.cross_validation import train_test_split
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.2, random_state = 0)                
                    
    from sklearn.model_selection import GridSearchCV
    parameters = {'vect__ngram_range': [(1, 1), (1, 2), (1, 3), (1, 4)],
                  'vect__max_features': (None, 1000, 10000, 100000),
                  'tfidf__use_idf': (True, False),
                  'clf__alpha': (1e-2, 1e-3),
                  'clf__max_iter': (5, 10, 20, 30)
    }
    
    
    
    from sklearn.pipeline import Pipeline
    from sklearn.linear_model import SGDClassifier
    text_clf = Pipeline([('vect', CountVectorizer()),
                         ('tfidf', TfidfTransformer()),
                         ('clf', SGDClassifier(loss='hinge', penalty='l2',
                                               alpha=1e-3, random_state=0,
                                               max_iter=5, tol=None))])
    
    #text_clf.fit(X_train, y_train)  
    gs_clf = GridSearchCV(text_clf, parameters, n_jobs=-1)
    gs_clf.fit(X_train, y_train)
    y_pred = gs_clf.predict(X_test)
    #gs_clf = gs_clf.fit(X_train, y_train)
    
    #apresenta os parametros que geraram os melhores resultados
    for param_name in sorted(parameters.keys()):
        print("%s: %r" % (param_name, gs_clf.best_params_[param_name]))
    
                     
    
    #y_pred = text_clf.predict(X_test)
    
    
    avaliar(y_test, y_pred)
    cross_fold(X_train, y_train, X_test, text_clf)
    return y_pred

def pipeline_svm_com_parametros_dinamicos(corpus, y):
    X = corpus
    #y = dataset.iloc[:, 1].values
                    
    from sklearn.cross_validation import train_test_split
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.5, random_state = 0)                
                    
    from sklearn.model_selection import GridSearchCV
    parameters = {'vect__ngram_range': [(1, 1), (1, 2), (1, 3), (1, 4)],
                  'vect__max_features': (None, 1000, 10000, 100000),
                  'tfidf__use_idf': (True, False),
                  'clf__kernel': ['linear', 'rbf', 'poly'],
                  'clf__C': [1,10],
                  'clf__gamma': [0.001, 0.0001],
                  'clf__cache_size': (100, 200, 300, 400)
    }
    
    from sklearn.svm import SVC
    from sklearn.pipeline import Pipeline
    
    text_clf = Pipeline(
            [
                    ('vect', CountVectorizer()),
                    ('tfidf', TfidfTransformer()),
                    ('clf', SVC())
            ],
            #[
            #        ('vect', CountVectorizer()),
            #        ('clf', SVC())
            #]
    )
    
    
    text_clf.fit(X_train, y_train)  
    clf = GridSearchCV(text_clf, parameters, n_jobs=-1, cv=10)
    clf.fit(X_train, y_train)
    
    #apresenta os parametros que geraram os melhores resultados
    print("Melhor resultado: %s" % clf.best_score_)
    print("Melhores parametros: %s" % clf.best_params_)
    
    melhor_classificador = clf.best_estimator_
    melhor_classificador.fit(X_train, y_train)
    y_pred = melhor_classificador.predict(X_test)
    avaliar(y_test, y_pred)
    
    return y_pred


def cross_fold(X_train, y_train, X_test, classifier):
    from sklearn.model_selection import cross_val_score, cross_validate
    acuracia = cross_val_score(estimator = classifier, X = X_train, y = y_train, cv = 10)
    
    resultado = cross_validate(estimator = classifier, X = X_train, y = y_train, cv = 10)
    #TODO: apresentar resultados do cross fold validation no mesmo formato do metrics.classification_report(y_test, y_pred)
    #print(resultado) #isso aqui não funciona
    
    print ("Acurácia do cross fold: %s" % acuracia.mean())



def avaliar(y_test, y_pred):
    # Making the Confusion Matrix
    
    #metrics.classification_report(y_test, y_pred, target_names=twenty_test.target_names)
    resultado = metrics.classification_report(y_test, y_pred)
    acuracia = metrics.accuracy_score(y_test, y_pred)
    cm = confusion_matrix(y_test, y_pred)
    print (resultado)
    print ("Acurácia: %s" % acuracia)

def get_dataset_opinioes():
    # Importing the dataset
    #dataset = pd.read_csv('Restaurant_Reviews.tsv', delimiter = '\t', quoting = 3)
    conn = psycopg2.connect(string_conexao)
    cur = conn.cursor()
    sql = "select s.texto, case when d.variavel_dependente = 'positiva' then 1 else 0 end as variavel_dependente from documento_para_treino d inner join sentenca s using (idsentenca) where d.variavel_dependente in ('positiva', 'negativa')"
    cur.execute(sql)
    
    dataset = pd.DataFrame(cur.fetchall(), columns=['texto', 'variavel_dependente'])
    
    cur.close()
    conn.close()
    return dataset


def get_dataset_assunto(assunto):
    # Importing the dataset
    #dataset = pd.read_csv('Restaurant_Reviews.tsv', delimiter = '\t', quoting = 3)
    conn = psycopg2.connect(string_conexao)
    cur = conn.cursor()
    sql = """
      select case 
              when s.tipo_texto = 'post' then s.post_texto
              when s.tipo_texto = 'comentario' then s.post_texto || s.comentario_texto
              when s.tipo_texto = 'comentario_de_comentario' then s.post_texto || s.comentario_texto
            end as texto, 
            case 
              when d.variavel_dependente = '"""+assunto+"""' then 1 
              else 0 
            end as variavel_dependente 
       from documento_para_treino d 
     inner join sentenca s using (idsentenca)
      where d.tipo in ('assunto')"""
    cur.execute(sql)
    
    dataset = pd.DataFrame(cur.fetchall(), columns=['texto', 'variavel_dependente'])
    
    cur.close()
    conn.close()
    return dataset
    

# Cleaning the texts
def prepare_corpus(dataset):
    
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
    return corpus


def aplicar_classificador(alvo):
    if (alvo == 'opiniao'):
        dataset = get_dataset_opinioes()
    else:
        dataset = get_dataset_assunto(alvo)
    
        
    print(alvo.upper())
    
    corpus = prepare_corpus(dataset)
    # Creating the Bag of Words model
    from sklearn.feature_extraction.text import CountVectorizer
    #cv = CountVectorizer(max_features = 150000)
    #cv = CountVectorizer(ngram_range = (1, 3))
    cv = CountVectorizer()
    X = cv.fit_transform(corpus).toarray()
    y = dataset.iloc[:, 1].values
    
                    
    #from sklearn.feature_extraction.text import TfidfTransformer
    #tf_transformer = TfidfTransformer(use_idf=False).fit(X)
    #tf_transformer = TfidfTransformer().fit(X)
    #X = tf_transformer.transform(X).toarray()                
    
    # Splitting the dataset into the Training set and Test set
    from sklearn.cross_validation import train_test_split
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.5, random_state = 0)
    
    naive(X_train, y_train, X_test, y_test)
    naive(X_train, y_train, X_test, y_test, realizar_scaling=True)
    svm(X_train, y_train, X_test, y_test)
    svm(X_train, y_train, X_test, y_test, realizar_scaling=True)
    random_tree(X_train, y_train, X_test, y_test)
    random_tree(X_train, y_train, X_test, y_test, realizar_scaling=True)
    xgboost(X_train, y_train, X_test, y_test)
    xgboost(X_train, y_train, X_test, y_test, realizar_scaling=True)
    #pipeline_SGDClassifier(corpus, y)
    #pipeline_SGDClassifier_com_parametros_dinamicos(corpus, y)
    pipeline_svm_com_parametros_dinamicos(corpus, y)
    print("")
    print("")
    print("")
    print("")
    print("")
    print("")

def main():
    
    lista = ['opiniao', 'saude', 'educacao', 'seguranca']
    for item in lista:
        aplicar_classificador(item)
    
    
    

if __name__ == "__main__":
    main()