# Documentação sobre a extração de dados do Facebook

A extração dos dados foram realizados em grupos públicos e privados. Os grupos públicos não necessitam de permissões adicionais para obter do posts, por outro lado os grupos privados necessitam de permissões de administrador.

## Facebook Graph API

Os dados foram extraídos utilizando a api disponibilizada pelo Facebook, utilizamos a versão 2.10.

### Token de acesso

Os tokens de acesso podem ser gerados na página do Facebook designado para o desenvolvedores (https://developers.facebook.com/tools/explorer/). Para os grupos privados que necessitam de permissões adicionais é necessário que o usuário que seja administrador daquele grupo gere um token de acesso.

Os tokens de acesso possuem tempo de expiração em torno de uma hora. É possível criar um token de longa duração que dura em torno de 60 dias.

### Como criar um token de longa duração:

É necessário criar um aplicação na página de desenvolvedores do facebook para obter os dados necessários

Link para obter o token: (https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id={key}&client_secret={key}&fb_exchange_token={short_live_token})

client_id (app_id):  ID do Aplicativo

client_secret = Chave Secreta do Aplicativo

fb_exchange_token = Token de curta duração gerado pelo usuário

Após a realização desses passos a reposta da requisição será o token de longa duração.

## Extrator

Para a extração das informações foi criado um script em python.

[Documentação](https://github.com/bigdatafaccat/mineracaoopiniaofaccat/tree/master/extrator)

## Servidor

Para salvar os dados coletos foi criado um servidor em node.js, utilizando o mongodb como banco de dados não relacional.

[Documentação](https://github.com/bigdatafaccat/mineracaoopiniaofaccat/tree/master/webservice)

## Pré-processamento

Fase 1:

É necessário realizar um get na rota ```preprocessing/fase1``` para a criação do "message_description".

TODO: Explicar o porque

Fase 2:

Para a segunda fase do pré-processamento foi desenvolvido um script em python, que divida o texto em sentenças e aplica o POS Tagging nessas sentenças.

Essas informações são salvas atráves da rota ```preprocessing/fase2``` do webservice.