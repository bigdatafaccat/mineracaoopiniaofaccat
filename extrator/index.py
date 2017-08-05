import facebook
import requests
import json

graph = facebook.GraphAPI("EAACEdEose0cBACAOowEvrVfmeiJHf9szF0lGglPGrv0HT8prfcXZBFdpJKECWyZAE4ZCuTVQEBePPqvceaRodHeygd6S0ic8lstE9LQDUdURDWJsramV9PFCmv1WII2ZBPmfM8eMCpgm5JgnrL60RjDZB5VnqVf56WS03zHJ1NRx3NJYZBtfS3qsOTGqW8uyJwFOZCAbkgKdQZDZD", version="2.9")  # Page access token
data = graph.get_object("160317500766953/feed?fields=id")

# fala igrejinha: 160317500766953


def createQueryString(groupId):
    # text = groupId + "?fields="
    text = "160317500766953_1112420062223354?fields="
    text += "admin_creator,application,backdated_time,"
    text += "call_to_action,child_attachments,actions,"
    text += "caption,coordinates,created_time,description,"
    text += "feed_targeting,from,event,icon,is_popular,link,"
    text += "message,message_tags,name,object_id,type,shares,"
    text += "story,source,properties,place,target,targeting,via,"
    text += "status_type,comments.fields(comment_count,from,id,like_count,"
    text += "permalink_url,created_time,message,comments.fields(comment_count,"
    text += "from,id,like_count,permalink_url,created_time,message,"
    text += "reactions.fields(id,name,type,username,profile_type))),"
    text += "reactions.fields(id,name,type,username,profile_type),"
    text += "sharedposts,story_tags"

    #text = "102365183719373_118906138731944?fields=comments{message,comments{message}}"

    text = "21785951839_10155845932211840?fields=comments{message,comments{message,reactions}}"

    return text

# Várias reactions 160317500766953_1108318819300145
# Vários comentários 160317500766953_1112420062223354


def seekMoreData(data):
    listData = []

    paging = data["paging"]

    while "next" in paging:
        nextUrl = paging["next"]

        r = requests.get(nextUrl).json()

        for x in r["data"]:
            listData.append(x)

        paging = r["paging"]

    return listData


# while(True):
try:
    d = data["data"]
    g = data["paging"]

    headers = {'Content-type': 'application/json', 'Accept': 'text/plain'}

    for x in d:
        queryString = createQueryString(x["id"])

        graphObject = graph.get_object(queryString)

        #postReactions = seekMoreData(graphObject["reactions"])

        # for record in postReactions:
        # graphObject["reactions"]["data"].append(record)

        postComments = seekMoreData(graphObject["comments"])

        for record in postComments:
            graphObject["comments"]["data"].append(record)

        for pC in graphObject["comments"]["data"]:
            if "comments" in pC:
                if "paging" in pC["comments"]:
                    postCommentsOfComments = seekMoreData(pC["comments"])
                    for post in postCommentsOfComments:
                        pC["comments"]["data"].append(post)
            if "reactions" in pC:
                if "paging" in pC["reactions"]:
                    postReactionsOfComments = seekMoreData(pC["reactions"])
                    for post in postReactionsOfComments:
                        pC["reactions"]["data"].append(post)

        for c in graphObject["comments"]["data"]:
            for cc in c["comments"]["data"]:
                if "reactions" in cc:
                    if "next" in cc["reactions"]["paging"]:
                        postCommentsOfCommentsReactions = seekMoreData(cc["reactions"])
                        for ccr in postCommentsOfCommentsReactions:
                            cc["reactions"]["data"].append(ccr)

        result = requests.post("http://localhost:3000/api/posts",
                               data=json.dumps(graphObject), headers=headers)

        print("Http status: " + str(result.status_code))
        break

    print('Next page')

    data = requests.get(g["next"]).json()
except Exception as e:
    print('Error: ' + str(e))
