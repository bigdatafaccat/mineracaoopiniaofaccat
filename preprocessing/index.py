# -*- coding: utf-8 -*-

import json
import nltk
from nltk.corpus import floresta
from string import punctuation
import requests
import re
import emoji

# nltk.download('floresta')


def convert_to_universal_tag(tag):
    tagdict = {
        'n': "NOUN",
        'num': "NUM",
        'v-fin': "VERB",
        'v-inf': "VERB",
        'v-ger': "VERB",
        'v-pcp': "VERB",
        'pron-det': "PRON",
        'pron-indp': "PRON",
        'pron-pers': "PRON",
        'art': "DET",
        'adv': "ADV",
        'conj-s': "CONJ",
        'conj-c': "CONJ",
        'conj-p': "CONJ",
        'adj': "ADJ",
        'ec': "PRT",
        'pp': "ADP",
        'prp': "ADP",
        'prop': "NOUN",
        'pro-ks-rel': "PRON",
        'proadj': "PRON",
        'prep': "ADP",
        'nprop': "NOUN",
        'vaux': "VERB",
        'propess': "PRON",
        'v': "VERB",
        'vp': "VERB",
        'in': "X",
        'prp-': "ADP",
        'adv-ks': "ADV",
        'dad': "NUM",
        'prosub': "PRON",
        'tel': "NUM",
        'ap': "NUM",
        'est': "NOUN",
        'cur': "X",
        'pcp': "VERB",
        'pro-ks': "PRON",
        'hor': "NUM",
        'pden': "ADV",
        'dat': "NUM",
        'kc': "ADP",
        'ks': "ADP",
        'adv-ks-rel': "ADV",
        'npro': "NOUN",
    }

    return tagdict.get(tag, "." if all(tt in punctuation for tt in tag) else tag)


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


def retrieve_traindata():
    tsents = floresta.tagged_sents()

    tsents = [[(w.lower(), simplify_tag(t)) for (w, t) in sent]
              for sent in tsents if sent]
    tsents = [[(w.lower(), convert_to_universal_tag(t)) for (w, t) in sent]
              for sent in tsents if sent]

    return tsents


def create_tagger():
    traindata = retrieve_traindata()

    tagger1 = nltk.DefaultTagger('NOUN')
    tagger2 = nltk.AffixTagger(traindata, backoff=tagger1)
    tagger3 = nltk.UnigramTagger(traindata, backoff=tagger2)
    tagger4 = nltk.RegexpTagger(patterns, backoff=tagger3)
    tagger5 = nltk.BigramTagger(traindata, backoff=tagger4)

    templates = nltk.tag.brill.fntbl37()
    tagger6 = nltk.BrillTaggerTrainer(tagger5, templates)
    tagger6 = tagger6.train(traindata)

    return tagger6


def main():
    headers = {'Content-type': 'application/json'}
    url = "http://localhost:3000/api/preprocessing/fase2"

    posts = get_posts()
    tagger = create_tagger()

    for post in posts["data"]:
        message_description = post["message_description"]

        sentences = []
        comments = []
        post_identifier = 0

        post_sentences = re.split('[?.!;]', message_description)

        for post_sentence in post_sentences:
            # Convertemos o emoji para representação em texto
            sentence_demojized = emoji.demojize(post_sentence)

            sentence_words = sentence_demojized.split(' ')
            sentence_tagged = tagger.tag(sentence_words)

            post_identifier += 1
            comment_identifier = 0
            sentences.append([post_identifier, post_sentence, sentence_tagged])

        if "comments" in post:
            for comment_data in post["comments"]["data"]:
                message = comment_data["message"]

                comment = []
                comments_c = []
                comment_words = message.split(' ')
                comment_tagged = tagger.tag(comment_words)
                comment_sentences = re.split('[?.!;]', message)

                for comment_sentence in comment_sentences:
                    comment_sentence_demojized = emoji.demojize(
                        comment_sentence)

                    comment_sentence_words = comment_sentence_demojized.split(
                        ' ')
                    comment_sentence_tagged = tagger.tag(
                        comment_sentence_words)

                    comment_identifier += 1
                    comment_c_identifier = 0
                    comment.append(
                        [comment_identifier, comment_sentence, comment_sentence_tagged])

                if "comments" in comment_data:
                    for comment_c_data in comment_data["comments"]["data"]:
                        c_message = comment_c_data["message"]

                        comment_c = []
                        comment_c_words = c_message.split(' ')
                        comment_c_tagged = tagger.tag(
                            comment_c_words)
                        comment_c_sentences = re.split(
                            '[?.!;]', c_message)

                        for comment_c_sentence in comment_c_sentences:
                            comment_c_sentence_demojized = emoji.demojize(
                                comment_c_sentence)

                            comment_c_sentence_words = comment_c_sentence_demojized.split(
                                ' ')
                            comment_c_sentence_tagged = tagger.tag(
                                comment_c_sentence_words)

                            comment_c_identifier += 1
                            comment_c.append(
                                [comment_c_identifier, comment_c_sentence, comment_c_sentence_tagged])

                        comments_c.append({"id": comment_c_data["id"],
                                           "sentences": comment_c,
                                           "tagged": comment_c_tagged})

                comments.append({"id": comment_data["id"],
                                 "comment_tagged": comment_tagged,
                                 "comment_sentences": comment,
                                 "comments": comments_c})

        post_message_words = message_description.split(' ')

        data = {
            "post_id": post["post_id"],
            "words_tagged": tagger.tag(post_message_words),
            "sentences": sentences,
            "comments": comments
        }

        result = requests.post(url, data=json.dumps(data), headers=headers)

        print("Http status: " + str(result.status_code) +
              " PostID: " + post["post_id"])


def get_posts():
    url = "http://localhost:3000/api/posts/pieces?startdate=2017-10-01&enddate=2018-01-01"

    return requests.get(url).json()


if __name__ == "__main__":
    main()
