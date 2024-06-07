# Inserindo dados na Planilha google 

## Instalação
Use o comando abaixo para renomear `example.env` para `.env`:
```sh
mv example.env le.env
```

## 1. Crie e configure sua conta na API do google 
Acesse no console do Google Cloud, a [Visão geral da API Google Workspace](https://console.cloud.google.com/workspace-api?hl=pt-br) para criar uma Chave de API no Google Console
- Primeiro acesse o Google Console: Se você nunca entrou no Google API’s você precisará criar um novo projeto.
- Em seguida você precisa acessar o Google API’s clicando no seguinte menu **APIs**
- Agora você já pode começar a criar uma credencial; Selecione no menu **Credenciais** e crie uma nova chave de API.
- Quando criar ele vai baixar um arquivo json salve ele que será preciso para gerar o token.

_**<span style="color: red;">ATENÇÃO!!</span>** Certifique de que o json não está disponivel para acesso externo, caso não seja possivel configure ele artavés do .env._

## 2. Crie sua planilha 
Crie sua planilha normalmente e adicione o email que foi gerado junto com a chave de api com permissão de **EDITAR**.
Agora copie o link de sua planilha e vc vai precisar copiar o código de sua planilha, observe o exemplo abaixo:

https://docs.google.com/spreadsheets/d/1JUzHM5Oz0rymw4aWfd9Ws1E7orp29LaFg-uQkBNWP62/edit#gid=0

No link você só vai precisar de **'1JUzHM5Oz0rymw4aWfd9Ws1E7orp29LaFg-uQkBNWP62'** copie e salve no seu arquivo .env em `SHEET_ID`

Escolha qual o intervalo da sua planilha que ficará seu conteúdo e dalse tambem no seu arquivo .env em `RANGE`

_Obs: Use essa estrutura para o intervalo [nome da planilha]![intevalo(linha : coluna)] EX: Sheet1!A1:D10_


> Mais informações:
>
> - [Desenvolver no Google Workspace](https://developers.google.com/workspace/guides/get-started?hl=pt-br)
> - [Link da documentação](https://developers.google.com/sheets/api/guides/concepts?hl=pt-br)