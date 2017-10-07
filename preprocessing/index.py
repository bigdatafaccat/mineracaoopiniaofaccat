import nltk
from nltk.corpus import floresta
import sys


nltk.download('floresta')


def simplify_tag(t):
    if "+" in t:
        return t[t.index("+") + 1:]
    else:
        return t


patterns = [
    (r"^[nN][ao]s?$", "ADP"),
    (r"^[dD][ao]s?$", "ADP"),
    (r"^[pP]el[ao]s?$", "ADP"),
    (r"^[nN]est[ae]s?$", "ADP"),
    (r"^[nN]um$", "ADP"),
    (r"^[nN]ess[ae]s?$", "ADP"),
    (r"^[nN]aquel[ae]s?$", "ADP"),
    (r"^\xe0$", "ADP")
]


def retrieveTrainData():
    tsents = floresta.tagged_sents()
    tsents = [[(w.lower(), simplify_tag(t)) for (w, t) in sent]
              for sent in tsents if sent]

    return tsents


def wordProcessing(phrases):
    traindata = retrieveTrainData()

    tagger1 = nltk.DefaultTagger('n')
    tagger2 = nltk.AffixTagger(traindata, backoff=tagger1)
    tagger3 = nltk.UnigramTagger(traindata, backoff=tagger2)
    tagger4 = nltk.RegexpTagger(patterns, backoff=tagger3)
    tagger5 = nltk.BigramTagger(traindata, backoff=tagger4)

    templates = nltk.tag.brill.fntbl37()
    tagger6 = nltk.BrillTaggerTrainer(tagger5, templates)
    tagger6 = tagger6.train(traindata)

    list_tagged_words = []

    for phrase in phrases:
        words = phrase.split(' ')
        list_tagged_words.append(tagger6.tag(words))

    return list_tagged_words


phrases = ['nos iremos ao cinema mais tarde',
           'hoje e um lindo dia']

if __name__ == "__main__":
    #result = wordProcessing(sys.argv[1:])
    result = wordProcessing(phrases)

    print(result)
