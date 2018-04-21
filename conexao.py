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
            #print ("Conexao estabelecida")
        
        except:
            print("I am unable to connect to the database")
            
    def desconectar(self):
        self.conn.close()
        
    def executar(self, sql, parametros=None):
        self.conectar()
        cur = self.conn.cursor()
        
        if (parametros == None):
            cur.execute(sql)
        else:
            cur.execute(sql, parametros)
        
        self.conn.commit()
        cur.close()
        self.desconectar()
        
    
    def obter(self, sql, parametros=None):
        self.conectar()
        cur = self.conn.cursor()
        
        if (parametros == None):
            cur.execute(sql)
        else:
            cur.execute(sql, parametros)
        
        retorno = cur.fetchall()
        
        self.conn.commit()
        cur.close()
        self.desconectar()
        
        return retorno
        