# -*- coding: utf-8 -*-

import json
import requests

access_token = "EAAbQNgyZA7akBADDFslVhDC13duN6n6DwLYZA20vZBLeNoG5CQmlTP1mVEnXvCCstuQtqwFaNlu6kHgE5FqyRqhdjwWVR7fXh9oU9BZCttSp1SiiCMjOtCGHqgZCdS2m7hEMhQASzAb4H2WFsnjVgpWOb5o7l2UkZD"


def create_url_post(post_id):
    text = "https://graph.facebook.com/"
    text += "v2.10"
    text += "/"
    text += post_id
    text += "?fields=id,message,permalink_url,"
    text += "comments.fields(id,message,"
    text += "reactions.fields(id,name,type,username,profile_type))"
    text += "&access_token="
    text += access_token

    return text


def get_posts():
    url = "http://localhost:3000/api/posts/pieces?startdate=2017-09-01&enddate=2017-12-01"

    return requests.get(url).json()


def seek_more_data(data):
    """
    Busca os dados por enquanto que tiver paginação
    """
    list_data = []

    paging = data["paging"]

    while "next" in paging:
        next_url = paging["next"]

        json_data = return_json(next_url)

        for json_item in json_data["data"]:
            list_data.append(json_item)

        paging = json_data["paging"]

    return list_data


def return_json(url):
    """
    Retorna um objeto json da url especificada
    """
    for attempt in range(1, 3):
        try:
            return requests.get(url, verify=True, stream=True).json()
        except:
            print('Trying again attempt: ' + str(attempt))


def main():
    headers = {'Content-type': 'application/json'}
    url = "http://localhost:3000/api/preprocessing/fix"

    posts = get_posts()

    print("GET OK")

    for post in posts["data"]:
        post_id = post["post_id"]
        group_id = post["target"]["id"]

        # Fala Taquara
        # if "160736474006171" == group_id:
        #     continue

        # Falta Taquara 2
        # if "857568257589250" == group_id:
        #     continue

        url_post = create_url_post(post_id)

        dataFacebook = requests.get(url_post).json()

        if not "comments" in post:
            continue

        for c_saved in post["comments"]["data"]:
            if not "comments" in dataFacebook:
                continue
            
            for c_facebook in dataFacebook["comments"]["data"]:
                if c_facebook["id"] != c_saved["id"]:
                    continue

                if not "reactions" in c_facebook:
                    continue

                if "next" in c_facebook["reactions"]["paging"]:
                    reactions_paging = seek_more_data(c_facebook["reactions"])

                    for reactions in reactions_paging:
                        c_facebook["reactions"]["data"].append(reactions)

                data = {
                    "post_id": post_id,
                    "message": c_facebook["message"],
                    "comment_id": c_facebook["id"],
                    "reactions": c_facebook["reactions"]
                }

                result = requests.post(
                    url, data=json.dumps(data), headers=headers)

                print("Http status: " + str(result.status_code)
                      + " " +
                      "CommentID: " + data["comment_id"]
                      + " " +
                      "PostID: " + post["post_id"])


if __name__ == "__main__":
    main()
