import json
import datetime
import traceback
import requests


def create_url_post(post_id, config):
    """
    Cria a url do post com os campos desejados
    """
    text = "https://graph.facebook.com/"
    text += config["graph_api_version"]
    text += "/" + post_id + "?fields="
    text += "id, message, admin_creator, backdated_time,"
    text += "caption,coordinates,created_time,description,"
    text += "feed_targeting,from,event,icon,is_popular,link,"
    text += "message_tags,name,object_id,type,shares,"
    text += "story,source,properties,place,target,targeting,"
    text += "status_type,comments.fields(comment_count,from,id,like_count,"
    text += "permalink_url,created_time,message,comments.fields(comment_count,"
    text += "from,id,like_count,created_time,message,"
    text += "reactions.fields(id,name,type,username,profile_type))),"
    text += "reactions.fields(id,name,type,username,profile_type), sharedposts"
    text += "&access_token=" + config["access_token"]

    return text


def create_url_feed(config):
    """
    Cria a url dos feeds da página
    """
    text = "https://graph.facebook.com/"
    text += config["graph_api_version"]
    text += "/"
    text += config["page_id"]
    text += "/"
    text += "feed?fields=created_time,id,permalink_url"
    text += "&access_token="
    text += config["access_token"]

    return text


def seek_more_data(data):
    """
    Busca os dados por enquanto que tiver paginação
    """
    list_data = []

    paging = data["paging"]

    while "next" in paging:
        next_url = paging["next"]

        json_data = requests.get(next_url, stream=True).json()

        for json_item in json_data["data"]:
            list_data.append(json_item)

        paging = json_data["paging"]

    return list_data


def read_config_file():
    """
    Lê o arquivo de configuração
    """
    with open('config.json') as json_data:
        data = json.load(json_data)

    return data


def main():
    headers = {'Content-type': 'application/json', 'Accept': 'text/plain'}

    config = read_config_file()

    post_limit_date = datetime.datetime.strptime(
        config["post_limit_date"], '%Y-%m-%d')

    limit_reached = False

    feed_url = create_url_feed(config)

    feeds = requests.get(feed_url, stream=True).json()

    while True:
        try:
            feeds_data = feeds["data"]
            feeds_paging = feeds["paging"]

            for feed in feeds_data:
                post_date = datetime.datetime.strptime(
                    feed["created_time"], '%Y-%m-%dT%H:%M:%S+0000')

                if post_limit_date.date() > post_date.date():
                    limit_reached = True
                    break

                print(feed["permalink_url"])

                post_url = create_url_post(feed["id"], config)

                graph_object = requests.get(post_url, stream=True).json()

                if "error" in graph_object:
                    print(graph_object["error"]["message"])
                    continue

                if "reactions" in graph_object:
                    post_reactions = seek_more_data(graph_object["reactions"])

                    for record in post_reactions:
                        graph_object["reactions"]["data"].append(record)

                if "comments" in graph_object:
                    post_comments = seek_more_data(graph_object["comments"])

                    for record in post_comments:
                        graph_object["comments"]["data"].append(record)

                    for pC in graph_object["comments"]["data"]:
                        if "comments" in pC:
                            if "paging" in pC["comments"]:
                                post_comments_of_comments = seek_more_data(
                                    pC["comments"])

                                for post in post_comments_of_comments:
                                    pC["comments"]["data"].append(post)

                        if "reactions" in pC:
                            if "paging" in pC["reactions"]:
                                post_reactions_of_comments = seek_more_data(
                                    pC["reactions"])

                                for post in post_reactions_of_comments:
                                    pC["reactions"]["data"].append(post)

                    if not "data" in graph_object["comments"]:
                        break

                    for comments in graph_object["comments"]["data"]:
                        if not "comments" in comments:
                            break

                        for comment_of_comments in comments["comments"]["data"]:
                            if not "reactions" in comment_of_comments:
                                break

                            if not "next" in comment_of_comments["reactions"]["paging"]:
                                break

                            comments_of_comments_reactions = seek_more_data(
                                comment_of_comments["reactions"])

                            for reactions in comments_of_comments_reactions:
                                reactions["reactions"]["data"].append(
                                    reactions)

                result = requests.post(config["webservice_url"],
                                       data=json.dumps(graph_object), headers=headers, stream=True)

                print("Http status: " + str(result.status_code))

            if limit_reached:
                print('Deadline reached')
                break

            if not "next" in feeds_paging:
                break

            print('Next page')

            feeds = requests.get(feeds_paging["next"], stream=True).json()
        except Exception:
            traceback.print_exc()
            break


if __name__ == "__main__":
    main()
