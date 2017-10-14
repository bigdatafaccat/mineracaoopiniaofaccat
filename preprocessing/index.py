import nltk
from nltk.corpus import floresta
import sys
import requests
import json

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


def createTagger():
    traindata = retrieveTrainData()

    tagger1 = nltk.DefaultTagger('n')
    tagger2 = nltk.AffixTagger(traindata, backoff=tagger1)
    tagger3 = nltk.UnigramTagger(traindata, backoff=tagger2)
    tagger4 = nltk.RegexpTagger(patterns, backoff=tagger3)
    tagger5 = nltk.BigramTagger(traindata, backoff=tagger4)

    templates = nltk.tag.brill.fntbl37()
    tagger6 = nltk.BrillTaggerTrainer(tagger5, templates)
    tagger6 = tagger6.train(traindata)

    return tagger6


def main():
    headers = {'Content-type': 'application/json', 'Accept': 'text/plain'}

    posts = getPosts()
    tagger = createTagger()

    for post in posts["data"]:
        words = post["message_description"].split(' ')

        data = {
            "post_id": post["post_id"],
            "words_tagged": tagger.tag(words)
        }

        result = requests.post("http://localhost:3000/api/preprocessing/fase2",
                               data=json.dumps(data), headers=headers)
        print(result.status_code)


def getPosts():
    return requests.get("http://localhost:3000/api/posts").json()


if __name__ == "__main__":
    main()
