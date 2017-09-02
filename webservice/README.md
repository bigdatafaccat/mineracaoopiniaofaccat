
# Webservice para salvar dados obtidos do Facebook.

### Http GET: api/posts
Busca todos os posts salvos no banco de dados

### Http GET: api/posts/pretty
Busca todos os posts salvos e os exibe de uma maneira mais amigável

### Http GET: api/posts/statistics
Retorna algumas informações sobre o os dados salvos

* Quantidade de posts por grupo 
* Quantidade de reações dos posts
* Quantidade de pessoas diferentes envolvidas
* Quantidade de comentários
* Média de reações dos posts
* Média de comentários dos posts
* Mediana das reações dos posts
* Mediana dos comentários dos posts


#### AMOSTRA

É possível obter uma amostra das informações passando o **startdate** e **enddate** como parâmetros

```Exemplo: api/posts/statistics?startdate=2017-08-15&enddate=2017-08-30```


### Http POST: api/posts
Inclui um post no banco de dados


### Http DELETE: api/posts/delete
Passando o id do registro para ser excluído

### Http DELETE: api/posts/deleteAll
Exclui todos os posts do banco de dados

## Instalar

Todas as dependências estão no arquivos package.json, é necessário possuir o node.js instalado e executar **npm install**.

## Como usar

Executar **npm run start** para subir o servidor.