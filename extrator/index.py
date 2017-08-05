import facebook
import requests
import json
import datetime

graph = facebook.GraphAPI("EAAbQNgyZA7akBAFKRgYFJPU6tg2VRgJJHGd01hA76yzsX77r1QMHXjmZBkCOVlZB6UXKLJtqwY8A1oYjKh4EtYXGv9PCPLjCAJ6cztTZC0OCLbiZBWWy2dON8NQXCcwgWpzpvq95lzQx4MnKhaQ840C8FuGtVmw39FQZAG1VOe8NkZBHVN9BZCgBeGXOhJU61WtL3rIi7lRZChgXPtmlUQchd", version="2.9")  # Page access token
feeds = graph.get_object("160317500766953/feed?fields=created_time,id")

longLiveToken = graph.extend_access_token(
    1917780418489769, "f7d69cbb36e1af37f04d3c723e4dc2b0")

graph = facebook.GraphAPI(longLiveToken["access_token"], version="2.9")

# fala igrejinha: 160317500766953


def createQueryString(groupId):
    #"21785951839_10155897661861840"
    text = groupId + "?fields="
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

    return text


def seekMoreData(data):
    listData = []

    paging = data["paging"]

    while "next" in paging:
        nextUrl = paging["next"]
        jsonData = requests.get(nextUrl).json()

        for jsonItem in jsonData["data"]:
            listData.append(jsonItem)

        paging = jsonData["paging"]

    return listData


while(True):
    try:
        feedsData = feeds["data"]
        feedsPaging = feeds["paging"]

        headers = {'Content-type': 'application/json', 'Accept': 'text/plain'}

        postLimitDate = datetime.datetime(2017, 8, 4)

        limitReached = False

        for feed in feedsData:
            postDate = datetime.datetime.strptime(
                feed["created_time"], '%Y-%m-%dT%H:%M:%S+0000')

            if postLimitDate.date() > postDate.date():
                limitReached = True
                break

            queryString = createQueryString(feed["id"])

            graphObject = graph.get_object(queryString)

            if "reactions" in graphObject:
                postReactions = seekMoreData(graphObject["reactions"])

                for record in postReactions:
                    graphObject["reactions"]["data"].append(record)

            if "comments" in graphObject:
                postComments = seekMoreData(graphObject["comments"])

                for record in postComments:
                    graphObject["comments"]["data"].append(record)

                for pC in graphObject["comments"]["data"]:
                    if "comments" in pC:
                        if "paging" in pC["comments"]:
                            postCommentsOfComments = seekMoreData(
                                pC["comments"])
                            for post in postCommentsOfComments:
                                pC["comments"]["data"].append(post)
                    if "reactions" in pC:
                        if "paging" in pC["reactions"]:
                            postReactionsOfComments = seekMoreData(
                                pC["reactions"])
                            for post in postReactionsOfComments:
                                pC["reactions"]["data"].append(post)

                if "data" in graphObject["comments"]:
                    for c in graphObject["comments"]["data"]:
                        if "comments" in c:
                            for cc in c["comments"]["data"]:
                                if "reactions" in cc:
                                    if "next" in cc["reactions"]["paging"]:
                                        postCommentsOfCommentsReactions = seekMoreData(
                                            cc["reactions"])
                                        for ccr in postCommentsOfCommentsReactions:
                                            cc["reactions"]["data"].append(ccr)

            result = requests.post("http://localhost:3000/api/posts",
                                   data=json.dumps(graphObject), headers=headers)

            print("Http status: " + str(result.status_code))

        print('Next page')

        if limitReached:
            break

        feedsData = requests.get(feedsPaging["next"]).json()
    except Exception as e:
        print('Error: ' + str(e))
        break
