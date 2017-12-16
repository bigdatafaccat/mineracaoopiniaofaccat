# -*- coding: utf-8 -*-

from nltk.tokenize import RegexpTokenizer
from stop_words import get_stop_words
from gensim import corpora, models
import nltk
import gensim

# nltk.download('stopwords')
# nltk.download('rslp')

tokenizer = RegexpTokenizer(r'\w+')

# create stop words list
pt_stop = nltk.corpus.stopwords.words('portuguese')

# Create p_stemmer of class RSLPStemmer
p_stemmer = nltk.stem.RSLPStemmer()

# create sample documents
doc_a = "Brocolli é bom para comer. Meu irmão gosta de comer bons brocolli, mas não minha mãe."
doc_b = "Minha mãe gasta muito tempo dirigindo meu irmão para a prática do futebol."
doc_c = "Alguns especialistas em saúde sugerem que a condução pode causar tensão aumentada e pressão arterial"
doc_d = "Muitas vezes eu sinto pressão para executar bem na escola, mas minha mãe nunca parece fazer com que meu irmão faça melhor."
doc_e = "Os profissionais de saúde dizem que o brocolli é bom para sua saúde."

# compile sample documents into a list
doc_set = [doc_a, doc_b, doc_c, doc_d, doc_e]

# list for tokenized documents in loop
texts = []

# loop through document list
for i in doc_set:
    # clean and tokenize document string
    raw = i.lower()
    tokens = tokenizer.tokenize(raw)

    # remove stop words from tokens
    stopped_tokens = [i for i in tokens if not i in pt_stop]

    # stem tokens
    stemmed_tokens = [p_stemmer.stem(i) for i in stopped_tokens]

    # add tokens to list
    texts.append(stemmed_tokens)

# turn our tokenized documents into a id <-> term dictionary
dictionary = corpora.Dictionary(texts)

# convert tokenized documents into a document-term matrix
corpus = [dictionary.doc2bow(text) for text in texts]

# generate LDA model
ldamodel = gensim.models.ldamodel.LdaModel(
    corpus, num_topics=2, id2word=dictionary, passes=20)

print(ldamodel.print_topics(num_topics=2, num_words=4))
