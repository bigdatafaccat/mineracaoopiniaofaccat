import facebook
import requests

graph = facebook.GraphAPI("") #Page access token
data = graph.get_object("160317500766953/feed?fields=id")

# fala igrejinha: 160317500766953

while(True):
    try:
        d = data["data"]
        g = data["paging"]

        for x in d:
            data = graph.get_object(
                x["id"] + "?fields=from,comments.fields(like),message,likes")

            result = requests.post(
                "http://localhost:3000/api/users", data=data)

            print("Http status: " + str(result.status_code))

        print('Next page')

        data = requests.get(g["next"]).json()
    except KeyError:
        print('error')
        break;
