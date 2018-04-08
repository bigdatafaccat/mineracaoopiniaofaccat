import psycopg2
import json
import os

json_data=open(os.path.abspath("../config.json")).read()
config = json.loads(json_data)['conexao-postgres']
string_conexao = "dbname='%s' user='%s' host='%s' password='%s'" % (config['banco'], config['usuario'], config['servidor'], config['senha'])

try:
    conn = psycopg2.connect(string_conexao)
    print ("Conexão estabelecida")

except:
    print("I am unable to connect to the database")