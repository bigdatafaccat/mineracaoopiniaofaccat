import facebook
import requests

graph = facebook.GraphAPI("EAACEdEose0cBAJPSo4DZCGlaZBfGk56aAvwnAIeSG3nOju3sebleeuxJw58ALoT3TZAxkJYC4Ia5VwnstZCdu72ZB7wnR1XtAOPBHQoXsrjbRiDfg4ko8b6M78ed9R35g5zblZBUm3DZBiPlZCtwl6J9wpvPNnqvBcWsFOCmWWFQKt8vBek8cfDcFrDigcnv1dwZD")
profile = graph.get_object(id="160317500766953_1059336457531715", fields="from,comments.fields(likes),message,likes")

r = requests.post("http://localhost:3000/api/users", data=profile)

print(r.status_code)
