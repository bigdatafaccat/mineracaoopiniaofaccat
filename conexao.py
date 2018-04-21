import psycopg2
import json
import os

class Conexao(object):
    conn = None
    
    def conectar(self):
        json_data=open(os.path.abspath("../config.json")).read()
        config = json.loads(json_data)['conexao-postgres']
        string_conexao = "dbname='%s' user='%s' host='%s' password='%s'" % (config['banco'], config['usuario'], config['servidor'], config['senha'])
        
        try:
            self.conn = psycopg2.connect(string_conexao)
            print ("Conexao estabelecida")
        
        except:
            print("I am unable to connect to the database")
            
    def desconectar(self):
        self.conn.close()
        