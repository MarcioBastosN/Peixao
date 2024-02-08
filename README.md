/* versao 02 - start docker */

#iniciando o docker
- sudo docker-compose up -d --build
#parar o docker
- sudo docker-compose down

----------------------

#conectando ao banco com DataGrip
host: localhost
porta: 5027
user e senha postgres

#acesando via docker (cmd ou comand)
- sudo docker exec -it peixao-db bash
- psql -U postgres
#Selecionando o DB
- \c peixao
#listar tabelas
- \dt

-----------------
importando modelo de tabelas