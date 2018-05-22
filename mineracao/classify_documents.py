#http://scikit-learn.org/stable/tutorial/text_analytics/working_with_text_data.html
#https://stackoverflow.com/questions/28384680/scikit-learns-pipeline-a-sparse-matrix-was-passed-but-dense-data-is-required
#http://zacstewart.com/2014/08/05/pipelines-of-featureunions-of-pipelines.html


from time import gmtime, strftime
import sys 
import os
import time
from unicodedata import normalize


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
from nltk.corpus import stopwords
import gc

from densetransformer import DenseTransformer
from sklearn.preprocessing import FunctionTransformer

#Não apresenta mensagens de warning
import warnings
from sklearn.model_selection import GridSearchCV
from sklearn.pipeline import Pipeline
from sklearn.neural_network import MLPClassifier
import json

class Experimento(object):
    
    algoritmo = None
    descricao = None
    oqueclassifica = None
    configuracao = None
    acuracia_train_test = None
    resultados_train_test = None
    acuracia_cross_validation = None
    resultados_cross_validation = None
    inicio = None
    fim = None
    matriz_confusao_train_test = None
    melhor_classificador = None
    idexperimento = None
    

class ClassifyDocuments(object):
    
    conn = None
    conexao = None
    cur = None
    lote = 0
    inicio = None
    fim = None
    experimento = None
    oqueclassifica = None
    n_cross_validation = 10
    verbose=3
    flag_classificar_documentos=True
    limite_dados=None
    #classificadores = ['svm', 'naive', 'random_tree', 'SDG', 'xgboost', 'MLP']
    classificadores = ['naive', 'random_tree', 'SDG', 'xgboost']
    #classificadores = ['svm']
    
    
    

    

    def mesclar_parametros(self, parametros1, parametros2):
        
        #funciona para Python abaixo de 3.4
        #z = parametros1.copy()   # start with x's keys and values
        #z.update(parametros2)    # modifies z with y's keys and values & returns None
        #return z
        
        #funciona para Python acima de 3.5
        return {**parametros1, **parametros2}
    
    
    def feature_scaling(self, X_train, X_test):
        # Feature Scaling
        from sklearn.preprocessing import StandardScaler
        sc = StandardScaler()
        X_train = sc.fit_transform(X_train)
        X_test = sc.transform(X_test)
        return [X_train, X_test]
    
    def naive(self, X_train, y_train, X_test, y_test, realizar_scaling = False):
        print("")
        print("")
        print("Naive Bayes")
        
        if (realizar_scaling):
            print("Com feature scaling")
            X_train, X_test = self.feature_scaling(X_train, X_test)
        
        #NAIVE BAYES
        # Fitting Naive Bayes to the Training set
        from sklearn.naive_bayes import GaussianNB
        classifier = GaussianNB()
        classifier.fit(X_train, y_train)
        y_pred = classifier.predict(X_test)
        
        self.avaliar(y_test, y_pred)
        self.cross_fold(X_train, y_train, X_test, classifier)
        return y_pred
    
    
    def svm(self, X_train, y_train, X_test, y_test, realizar_scaling = False):
        print("")
        print("")
        print("SVM")
        
        if (realizar_scaling):
            print("Com feature scaling")
            X_train, X_test = self.feature_scaling(X_train, X_test)
            
        #SVM
        from sklearn.svm import SVC
        classifier = SVC(kernel = 'linear', random_state = 0)
        #classifier = SVC(kernel = 'rbf', random_state = 0)
        #classifier = SVC(kernel = 'linear')
        classifier.fit(X_train, y_train)
        y_pred = classifier.predict(X_test)
        self.avaliar(y_test, y_pred)
        self.cross_fold(X_train, y_train, X_test, classifier)
        return y_pred
    
    def xgboost(self, X_train, y_train, X_test, y_test, realizar_scaling = False):
        print("")
        print("")
        print("XGBoost")
        
        if (realizar_scaling):
            print("Com feature scaling")
            X_train, X_test = self.feature_scaling(X_train, X_test)
            
        #SVM
        from xgboost import XGBClassifier
        classifier = XGBClassifier()
        classifier.fit(X_train, y_train)
        y_pred = classifier.predict(X_test)
        self.avaliar(y_test, y_pred)
        self.cross_fold(X_train, y_train, X_test, classifier)
        return y_pred
    
    def random_tree(self, X_train, y_train, X_test, y_test, realizar_scaling = False):
        print("")
        print("")
        print("Random tree")
        if (realizar_scaling):
            print("Com feature scaling")
            X_train, X_test = self.feature_scaling(X_train, X_test)
            
        #RANDOM TREE
        # Fitting Decision Tree Classification to the Training set
        from sklearn.tree import DecisionTreeClassifier
        classifier = DecisionTreeClassifier(criterion = 'entropy', random_state = 0)
        classifier.fit(X_train, y_train)
        y_pred = classifier.predict(X_test)
        self.avaliar(y_test, y_pred)
        self.cross_fold(X_train, y_train, X_test, classifier)
        return y_pred
    
    def pipeline_SGDClassifier(self, corpus, y):
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
        self.avaliar(y_test, y_pred)
        self.cross_fold(X_train, y_train, X_test, text_clf)
        return y_pred
    
    def pipeline_SGDClassifier_com_parametros_dinamicos(self, corpus, y):
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
        
        
        self.avaliar(y_test, y_pred)
        self.cross_fold(X_train, y_train, X_test, text_clf)
        return y_pred
    
    def pipeline_svm_com_parametros_dinamicos(self, corpus, y):
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
        self.avaliar(y_test, y_pred)
        
        return y_pred
    
    
    def cross_fold(self, X_train, y_train, X_test, classifier):
        from sklearn.model_selection import cross_val_score, cross_validate
        acuracia = cross_val_score(estimator = classifier, X = X_train, y = y_train, cv = self.n_cross_validation)
        
        resultado = cross_validate(estimator = classifier, X = X_train, y = y_train, cv = self.n_cross_validation)
        #TODO: apresentar resultados do cross fold validation no mesmo formato do metrics.classification_report(y_test, y_pred)
        #print(resultado) #isso aqui não funciona
        
        print ("Acurácia do cross fold: %s" % acuracia.mean())
    
    
    
    def avaliar(self, y_test, y_pred):
        # Making the Confusion Matrix
        
        #metrics.classification_report(y_test, y_pred, target_names=twenty_test.target_names)
        resultado = metrics.classification_report(y_test, y_pred)
        acuracia = metrics.accuracy_score(y_test, y_pred)
        cm = confusion_matrix(y_test, y_pred)
        
        self.experimento.acuracia_train_test = acuracia
        self.experimento.resultados_train_test = resultado
        self.experimento.matriz_confusao_train_test = cm
        
        
        print (resultado)
        print ("Acurácia: %s" % acuracia)
    
    
    def get_dataset_para_classificar(self):
        sql = """
        """
        if (self.experimento.oqueclassifica == 'opiniao' or self.experimento.oqueclassifica == 'com_sem_opiniao'):
            sql = """
                select post_id,
                       comentario_id,
                       comentario_comentario_id,
                       sentenca_id,
                       texto,
                       tipo_texto
                  from sentenca_tmp
              group by 1,2,3,4,5,6
            """
        elif (self.experimento.oqueclassifica == 'vale_paranhana' or 
              self.experimento.oqueclassifica == 'saude' or
              self.experimento.oqueclassifica == 'educacao' or
              self.experimento.oqueclassifica == 'seguranca'):
            sql = """
                select post_id,
                       '' as comentario_id,
                       '' as comentario_comentario_id,
                       '' as sentenca_id,
                       post_texto as texto,
                       tipo_texto
                  from sentenca_tmp
                 where tipo_texto = 'post'
              group by 1,2,3,4,5,6
              
                 union
              
                select post_id,
                       comentario_id,
                       '' as comentario_comentario_id,
                       '' as sentenca_id,
                       comentario_texto as texto,
                       tipo_texto
                  from sentenca_tmp
                 where tipo_texto = 'comentario'
              group by 1,2,3,4,5,6
              
                 union
            
                select post_id,
                       comentario_id,
                       comentario_comentario_id,
                       '' as sentenca_id,
                       comentario_comentario_texto as texto,
                       tipo_texto
                  from sentenca_tmp
                 where tipo_texto = 'comentario_de_comentario'
              group by 1,2,3,4,5,6            
            """
        else:
            print("ERRRROOOOUUU")
            sys.exit(0)
            
        if (self.limite_dados != None):
            sql = sql + " limit " + str(self.limite_dados)
            
        registros = self.conexao.obter(sql)
        dataset = pd.DataFrame(registros, columns=['post_id', 'comentario_id', 'comentario_comentario_id', 'sentenca_id', 'texto', 'tipo_texto'])
        
        return dataset
    
    def get_dataset_com_sem_opinioes(self):
        # Importing the dataset
        sql = """
            select s.texto, 
              case 
                when d.variavel_dependente = 'positiva' or variavel_dependente = 'negativa' then 1 
                else 0 
              end as variavel_dependente,
              s.sentenca_id as chave
              from documento_para_treino d 
        inner join sentenca_tmp s using (idsentenca) 
             where d.variavel_dependente in ('positiva', 'negativa', 'nenhuma')
               and d.tipo = 'opiniao'
             group by 1,2,3"""
        if (self.limite_dados != None):
            sql = sql + " limit " + str(self.limite_dados)
        registros = self.conexao.obter(sql)
        dataset = pd.DataFrame(registros, columns=['texto', 'variavel_dependente', 'chave'])
        return dataset
    
    def get_dataset_opinioes(self):
        # Importing the dataset
        sql = """
            select s.texto, 
              case 
                when d.variavel_dependente = 'positiva' then 1 
                else 0 
              end as variavel_dependente,
              s.sentenca_id as chave
              from documento_para_treino d 
        inner join sentenca_tmp s using (idsentenca) 
             where d.variavel_dependente in ('positiva', 'negativa')
               and d.tipo = 'opiniao'
             group by 1,2,3"""
        if (self.limite_dados != None):
            sql = sql + " limit " + str(self.limite_dados)
        registros = self.conexao.obter(sql)
        dataset = pd.DataFrame(registros, columns=['texto', 'variavel_dependente', 'chave'])
        return dataset
    
    def get_dataset_vale_paranhana(self):
        # Importing the dataset
        sql = """
            select case 
                      when s.tipo_texto = 'post' then s.post_texto
                      when s.tipo_texto = 'comentario' then s.post_texto || '. ' || s.comentario_texto
                      when s.tipo_texto = 'comentario_de_comentario' then s.post_texto || '. ' || s.comentario_comentario_texto
                    end as texto, 
                   case when d.variavel_dependente = 'True' then 1 else 0 end as variavel_dependente,
                   s.tipo_texto,
                   case 
                      when s.tipo_texto = 'post' then s.post_id
                      when s.tipo_texto = 'comentario' then s.post_id || '_' || s.comentario_id
                      when s.tipo_texto = 'comentario_de_comentario' then s.post_id || '_' || s.comentario_comentario_id
                    end as chave
              from documento_para_treino d 
        inner join sentenca_tmp s using (idsentenca)
             where d.tipo = 'vale_paranhana'
             group by 1,2,3,4"""
        if (self.limite_dados != None):
            sql = sql + " limit " + str(self.limite_dados)
        registros = self.conexao.obter(sql)
        dataset = pd.DataFrame(registros, columns=['texto', 'variavel_dependente', 'tipo_texto', 'chave'])
        return dataset
    
    
    def get_dataset_assunto(self, assunto):
        # Importing the dataset
        #dataset = pd.read_csv('Restaurant_Reviews.tsv', delimiter = '\t', quoting = 3)
        
        sql = """
          select case 
                  when s.tipo_texto = 'post' then s.post_texto
                  when s.tipo_texto = 'comentario' then s.post_texto || s.comentario_texto
                  when s.tipo_texto = 'comentario_de_comentario' then s.post_texto || s.comentario_comentario_texto
                end as texto, 
                case 
                  when d.variavel_dependente = '"""+assunto+"""' then 1 
                  else 0 
                end as variavel_dependente,
                s.tipo_texto,
                   case 
                      when s.tipo_texto = 'post' then s.post_id
                      when s.tipo_texto = 'comentario' then s.post_id || '_' || s.comentario_id
                      when s.tipo_texto = 'comentario_de_comentario' then s.post_id || s.comentario_comentario_id
                    end as chave
           from documento_para_treino d 
         inner join sentenca_tmp s using (idsentenca)
          where d.tipo in ('assunto')
          group by 1,2,3,4"""
        if (self.limite_dados != None):
            sql = sql + " limit " + str(self.limite_dados)
        registros = self.conexao.obter(sql)
        dataset = pd.DataFrame(registros, columns=['texto', 'variavel_dependente', 'tipo_texto', 'chave'])
        return dataset
        
    
    # Cleaning the texts
    def prepare_corpus(self, dataset):
        
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
    
    
    def obter_treino_teste(self, dataset):
        
        corpus = self.prepare_corpus(dataset)
        
        X = corpus
        y = dataset.iloc[:, 1].values
        
        from sklearn.cross_validation import train_test_split
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.5, random_state = 0)
        return [X_train, X_test, y_train, y_test]
        
    
    def obter_classificador_svm(self):
        self.experimento = Experimento()
        self.experimento.algoritmo = "SVM"
        self.experimento.inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
        
        parametros = {'clf__kernel': ['linear', 'rbf', 'poly', 'sigmoid'],
                      'clf__C': [0.001, 0.01, 1, 10, 100],
                      'clf__gamma': [1, 10, 100, 0.1, 0.01, 0.001, 0.0001, 'auto'],
                      'clf__cache_size': [300],
                      #'clf__degree': [1,2,3,4,5,7,8,9,10]
                      'clf__degree': [1,2,3,4,5]
        }
        """parametros = {'clf__kernel': ['linear'],
                      'clf__C': [0.001],
                      'clf__gamma': ['auto'],
                      'clf__cache_size': [100],
                      'clf__degree': [1]
        }"""
        
        from sklearn.svm import SVC
        classificador = SVC()
        
        pipeline = Pipeline(
                [
                        ('vect', CountVectorizer()),
                        ('tfidf', TfidfTransformer()),
                        ('clf', classificador)
                ],
        )
        
        
        return [classificador, parametros, pipeline]
    
    def obter_classificador_naive(self):
        self.experimento = Experimento()
        self.experimento.algoritmo = "Naive Bayes"
        self.experimento.inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
        
        parametros = {
        }
        
        from sklearn.naive_bayes import GaussianNB
        classificador = GaussianNB()
        
        pipeline = Pipeline(
                [
                        ('vect', CountVectorizer()),
                        ('tfidf', TfidfTransformer()),
                        ('to_dense', DenseTransformer()),
                        ('clf', classificador)
                ],
        )
        
        
        return [classificador, parametros, pipeline]
        
    
    def obter_classificador_random_tree(self):
        self.experimento = Experimento()
        self.experimento.algoritmo = "RANDOM TREE"
        self.experimento.inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
        
        parametros = {
        }
        
        from sklearn.tree import DecisionTreeClassifier
        classificador = DecisionTreeClassifier(criterion = 'entropy', random_state = 0)
        pipeline = Pipeline(
                [
                        ('vect', CountVectorizer()),
                        ('tfidf', TfidfTransformer()),
                        ('clf', classificador)
                ],
        )
        
        
        return [classificador, parametros, pipeline]
    
    
    def obter_classificador_xgboost(self):
        self.experimento = Experimento()
        self.experimento.algoritmo = "XGBOOST"
        self.experimento.inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
        
        parametros = {
        }
        
        from xgboost import XGBClassifier
        classificador = XGBClassifier()
        pipeline = Pipeline(
                [
                        ('vect', CountVectorizer()),
                        ('tfidf', TfidfTransformer()),
                        ('to_dense', DenseTransformer()),
                        ('clf', classificador)
                ],
        )
        
        
        return [classificador, parametros, pipeline]
    
    def obter_classificador_SDG(self):
        self.experimento = Experimento()
        self.experimento.algoritmo = "SDG"
        self.experimento.inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
        
        
        print("SDG")
        parametros = {'clf__loss': ['hinge'],
                      'clf__penalty': ['l2'],
                      'clf__alpha': [1e-3],
                      'clf__random_state': [0, None],
                      'clf__n_iter': [5],
                      'clf__tol': [None]
        }
        
        from sklearn.linear_model import SGDClassifier
        classificador = SGDClassifier()
        pipeline = Pipeline(
                [
                        ('vect', CountVectorizer()),
                        ('tfidf', TfidfTransformer()),
                        ('clf', classificador)
                ],
        )
        
        
        return [classificador, parametros, pipeline]
    
    
    def obter_classificador_MLP(self):
        self.experimento = Experimento()
        self.experimento.algoritmo = "MLP"
        self.experimento.inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
        
        
        #http://scikit-learn.org/stable/modules/neural_networks_supervised.html
        
        parametros = {
                      'clf__activation': ['identity', 'logistic', 'tanh', 'relu'],
                      #'clf__activation': ['relu'],
                      'clf__alpha': [1e-05],
                      'clf__batch_size': ['auto'],
                      'clf__beta_1': [0.9],
                      'clf__beta_2': [0.999],
                      'clf__early_stopping': [True, False],
                      'clf__epsilon': [1e-8],
                      'clf__hidden_layer_sizes': [(5,), (10,), (15,), (30,3)],
                      #'clf__hidden_layer_sizes': [(5,), (10,)],
                      'clf__learning_rate': ['constant', 'invscaling', 'adaptive'],
                      'clf__learning_rate_init': [0.001],
                      'clf__max_iter': [200],
                      'clf__momentum': [0.9],
                      'clf__nesterovs_momentum': [True, False],
                      'clf__power_t': [0.5],
                      'clf__shuffle': [True, False],
                      'clf__solver': ['lbfgs', 'sgd', 'adam'],
                      'clf__tol': [0.0001],
                      'clf__validation_fraction': [0.1],
                      'clf__warm_start': [True, False]
        }
        
        """
        parametros = {
                'clf__hidden_layer_sizes': [(5,2)],
                'clf__solver': ['lbfgs'],
                'clf__alpha': [1e-5],
                'clf__random_state': [1]
        }
        """
        
        classificador = MLPClassifier()
        pipeline = Pipeline(
                [
                        ('vect', CountVectorizer()),
                        ('tfidf', TfidfTransformer()),
                        ('to_dense', DenseTransformer()),
                        ('clf', classificador)
                ],
        )
        
        
        return [classificador, parametros, pipeline]
    
    def classificar_com_pipeline(self, dataset, propriedades_classificador):
        print(self.experimento.algoritmo.upper())
        print(self.oqueclassifica.upper())
        
        classificador, parametros, pipeline = propriedades_classificador
        self.experimento.oqueclassifica = self.oqueclassifica
        
        parametros_comuns = {
            'vect__ngram_range': [(1, 1), (1, 2), (1, 3), (1, 4)],
            'vect__max_features': (1000, 10000, 100000, 200000),
            #'vect__max_features': [1000]                    ,
            'tfidf__use_idf': (True, False)
        }
        parametros_mesclados = self.mesclar_parametros(parametros_comuns, parametros)
        
        X_train, X_test, y_train, y_test = self.obter_treino_teste(dataset)
        
        pipeline.fit(X_train, y_train)  
        clf = GridSearchCV(pipeline, parametros_mesclados, n_jobs=-1, cv=self.n_cross_validation, verbose=self.verbose)
        clf.fit(X_train, y_train)
        
        #apresenta os parametros que geraram os melhores resultados
        print("Melhor resultado: %s" % clf.best_score_)
        print("Melhores parametros: %s" % clf.best_params_)
        
        melhor_classificador = clf.best_estimator_
        melhor_classificador.fit(X_train, y_train)
        y_pred = melhor_classificador.predict(X_test)
        self.avaliar(y_test, y_pred)
        
        
        self.experimento.melhor_classificador = clf.best_estimator_
        self.experimento.configuracao = clf.best_params_
        self.experimento.acuracia_cross_validation = clf.best_score_
        self.experimento.fim = strftime("%Y-%m-%d %H:%M:%S", gmtime())
        
        self.experimento.idexperimento = self.registrarExperimento()
        
        return [clf.best_score_, X_train, y_train]
    
    def classificar_documentos(self, idexperimento, classificador, X_train, y_train):
        print("Obtendo dataset para classificação "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
        dataset = self.get_dataset_para_classificar()
        corpus = self.prepare_corpus(dataset)
        X_test = corpus
        print("Momento de treino "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
        classificador.fit(X_train, y_train)
        print("Momento de classificação "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
        y_pred = classificador.predict(X_test)
        
        print("Registrando classificação no banco "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
        for indice in range(0, len(dataset)):
            #string = "sentenca_id %s previsto %s" % (str(dataset['sentenca_id'][indice]), str(y_pred[indice]))
            #print(string)
            
            sql = """
            insert into documento_classificado 
            (idexperimentos_avaliacao_resultado, 
            sentenca_id, 
            post_id,
            comentario_id,
            comentario_comentario_id,
            texto,
            tipo_texto,
            oqueclassifica,
            variavel_dependente)
            values (
            %s,
            %s,
            %s,
            %s,
            %s,
            %s,
            %s,
            %s,
            %s)"""
            parametros = (
                str(idexperimento),
                str(dataset['sentenca_id'][indice]),
                str(dataset['post_id'][indice]),
                str(dataset['comentario_id'][indice]),
                str(dataset['comentario_comentario_id'][indice]),
                str(dataset['texto'][indice]),            
                str(dataset['tipo_texto'][indice]),
                str(self.experimento.oqueclassifica),
                str(y_pred[indice])   
            )
            self.conexao.executar(sql, parametros)
            
        print("Classificação de documentos concluída em "+strftime("%Y-%m-%d %H:%M:%S", gmtime()))
        
        
    
    
    def aplicar_classificador(self, alvo):
        if (alvo == 'opiniao'):
            dataset = self.get_dataset_opinioes()
        elif (alvo == 'com_sem_opiniao'):
            dataset = self.get_dataset_com_sem_opinioes()
        elif (alvo == 'vale_paranhana'):
            dataset = self.get_dataset_vale_paranhana()
        else:
            dataset = self.get_dataset_assunto(alvo)
        
        print(alvo.upper())
        
        self.oqueclassifica = alvo

        melhor_resultado = 0
        melhor_experimento = None
        melhor_X_train = None
        melhor_y_train = None
        
        for classificador in self.classificadores:
            metodo = getattr(self, 'obter_classificador_'+classificador)
            resultado_tmp, X_train, y_train = self.classificar_com_pipeline(dataset, metodo())
            self.classificar_documentos(self.experimento.idexperimento, self.experimento.melhor_classificador, X_train, y_train)
            gc.collect()
            
            
            if (resultado_tmp > melhor_resultado):
                melhor_resultado = resultado_tmp
                melhor_experimento = self.experimento
                melhor_X_train = X_train
                melhor_y_train = y_train
            print("Classificaria com o "+melhor_experimento.algoritmo)
                
            
        
        #print("Classificaria com o "+melhor_experimento.algoritmo)
        #if (self.flag_classificar_documentos):
            #self.classificar_documentos(melhor_experimento.idexperimento, melhor_experimento.melhor_classificador, melhor_X_train, melhor_y_train)
        
        gc.collect()
        
        #self.classificar_com_pipeline(dataset, self.obter_classificador_svm())
        #gc.collect()
        #self.classificar_com_pipeline(dataset, self.obter_classificador_naive())
        #gc.collect()
        #self.classificar_com_pipeline(dataset, self.obter_classificador_random_tree())
        #gc.collect()
        #self.classificar_com_pipeline(dataset, self.obter_classificador_SDG())
        #gc.collect()
        #self.classificar_com_pipeline(dataset, self.obter_classificador_xgboost())
        #gc.collect()
        #self.classificar_com_pipeline(dataset, self.obter_classificador_MLP())
        #gc.collect()
        
        #Trabalhos futuros
        #Implementar RNN com LSTM
        #https://medium.com/@shivambansal36/language-modelling-text-generation-using-lstms-deep-learning-for-nlp-ed36b224b275
        
        print("")
        print("")
        print("")
        print("")
        print("")
        print("")
        
        
    def obterUltimoLote(self):
        sql = "select (coalesce(max(lote_numero), 0) + 1) as lote from experimentos_avaliacao_resultado"
        registro = self.conexao.obter(sql)
        self.lote = registro[0][0]
        
    def atualizarExperimentosEmLote(self):
        sql = "update experimentos_avaliacao_resultado set lote_fim = %s where lote_numero = %s"
        parametros = (self.fim, self.lote)
        self.conexao.executar(sql, parametros)
        
        
    def registrarExperimento(self):
        
        sql = """
        select nextval('experimentos_avaliacao_result_idexperimentos_avaliacao_resu_seq')
        """
        registro = self.conexao.obter(sql)
        idexperimento = registro[0][0]
        
        sql = """
        insert into experimentos_avaliacao_resultado 
        (
        idexperimentos_avaliacao_resultado,
        algoritmo,
        descricao,
        oqueclassifica,
        configuracao,
        acuracia_train_test,
        resultados_train_test,
        acuracia_cross_validation,
        resultados_cross_validation,
        lote_numero,
        lote_inicio,
        lote_fim,
        experimento_inicio,
        experimento_fim,
        matriz_confusao_train_test,
        melhor_classificador
        )
        
        values (
        %s,
        %s,
        %s,
        %s,
        %s,
        %s,
        %s,
        %s,
        %s,
        %s,
        %s,
        %s,
        %s,
        %s,
        %s,
        %s
        )
        
        
        """
        parametros = (
            str(idexperimento),
            str(self.experimento.algoritmo),
            str(self.experimento.descricao),
            str(self.experimento.oqueclassifica),
            str(self.experimento.configuracao),
            str(self.experimento.acuracia_train_test),
            str(self.experimento.resultados_train_test),
            str(self.experimento.acuracia_cross_validation),
            str(self.experimento.resultados_cross_validation),
            str(self.lote),
            str(self.inicio),
            str(self.fim),
            str(self.experimento.inicio),
            str(self.experimento.fim),
            str(self.experimento.matriz_confusao_train_test),
            str(self.experimento.melhor_classificador)
        )
        
        self.conexao.executar(sql, parametros)
        return idexperimento
    
    def preparar_dados_temporarios(self):
        sql = """
        drop table if exists sentenca_tmp;
        create table sentenca_tmp as 
        (select * from sentenca where post_datahora::date >= '2017-01-01'::date
                   and post_datahora::date <= '2017-07-01'::date
                   and not similar_outra
                   and similaridade_analisada
                   and tamanho_post_texto > 2)
        """
        self.conexao.executar(sql)
    
    def remover_dados_temporarios(self):
        sql = """drop table if exists sentenca_tmp"""
        self.conexao.executar(sql)
        
        

def main():
    
    classifyDocuments = ClassifyDocuments()
    classifyDocuments.inicio = strftime("%Y-%m-%d %H:%M:%S", gmtime())
    print("Início do script")
    print(classifyDocuments.inicio)
    
    

    sys.path.append(os.path.abspath("../"))
    from conexao import Conexao
    classifyDocuments.conexao = Conexao()
    classifyDocuments.preparar_dados_temporarios()
    
    lista = ['opiniao', 'com_sem_opiniao', 'saude', 'educacao', 'seguranca', 'vale_paranhana']
    #lista = ['opiniao', 'seguranca', 'vale_paranhana']
    #lista = ['saude', 'educacao', 'seguranca', 'vale_paranhana']
    #lista = ['seguranca', 'vale_paranhana']
    #lista = ['opiniao']
    
    classifyDocuments.obterUltimoLote()
    for item in lista:
        classifyDocuments.aplicar_classificador(item)
    

    print("Início do script")
    print(classifyDocuments.inicio)
    print("Fim do script")
    classifyDocuments.fim = strftime("%Y-%m-%d %H:%M:%S", gmtime())
    print(classifyDocuments.fim)
    
    classifyDocuments.atualizarExperimentosEmLote()
    classifyDocuments.remover_dados_temporarios()
    
    
    
    
if __name__ == "__main__":
    os.environ['TZ'] = 'America/Sao_Paulo'
    time.tzset()
    warnings.filterwarnings("ignore")
    main()
    
