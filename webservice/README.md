
Webservice para salvar dados obtidos do Facebook.
=

### Http GET: api/posts
Buscar todos os posts salvos no banco de dados

### Http GET: api/posts/pretty
Busca todos os posts salvos e os exibe de uma maneira mais amigável


### Http POST: api/posts: 
Inclui um post no banco de dados


### Http DELETE: api/posts/delete
Passando o id do registro para ser excluído

### Http DELETE: api/posts/deleteAll
Exclui todos os posts do banco de dados

## Instalar

Todas as dependências estão no arquivos package.json, é necessário possuir o node.js instalado e executar **npm install**.

## Como usar

Executar **npm run start** para subir o servidor.