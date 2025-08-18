# Encurtador de URL

Este é um encurtador de URL simples, construído com Laravel 11. O projeto inclui funcionalidades de registro, login, e encurtamento de URLs para usuários autenticados, com rastreamento de cliques.

## 🚀 Tecnologias Utilizadas

- **Laravel 11**: Framework PHP para a API.
- **Laravel Sanctum**: Autenticação via API Tokens.
- **PostgreSQL**: Banco de dados para persistência de dados.
- **Docker**: Ambiente de desenvolvimento padronizado.

## 📦 Como Rodar o Projeto

Este projeto utiliza Docker para criar um ambiente de desenvolvimento isolado.

1.  **Clone o repositório:**

    ```bash
    git clone [https://github.com/seu-usuario/seu-projeto.git](https://github.com/seu-usuario/seu-projeto.git)
    cd seu-projeto
    ```

2.  **Inicie o ambiente Docker:**

    ```bash
    docker-compose up -d --build
    ```

3.  **Instale as dependências do Composer:**

    ```bash
    docker exec shortener_app composer install
    ```

4.  **Configure o arquivo de ambiente:**

    Crie uma cópia do `.env.example` e renomeie-a para `.env`.

    ```bash
    cp .env.example .env
    ```

    Ajuste a variável `DB_HOST` para `db` para garantir que o contêiner da aplicação possa se comunicar com o contêiner do banco de dados.

    ```ini
    DB_HOST=db
    ```

5.  **Gere a chave da aplicação e rode as migrações:**

    ```bash
    docker exec shortener_app php artisan key:generate
    docker exec shortener_app php artisan migrate
    ```

6.  **O projeto estará acessível em:**

    `http://localhost:9000`

## ⚙️ Testando as Funcionalidades

As funcionalidades principais foram desenvolvidas com TDD (Test-Driven Development). Você pode rodar os testes de integração e de unidade com o seguinte comando:

```bash
docker exec shortener_app php artisan test

```
## 🧪 Fluxo de Teste (Via Insomnia/Postman)
Siga este fluxo para testar o comportamento da API na prática:


## 1. Cadastro de Usuário
URL: http://localhost:9000/api/register


Método: POST

Headers: Content-Type: application/json

Body (JSON):

```
{
  "name": "João",
  "email": "joao@example.com",
  "password": "minhasenha",
  "password_confirmation": "minhasenha"
}
```

Response:

{
	"message": "Usuário criado com sucesso!",
	"user": {
		"name": "joao",
		"email": "joao@teste.com",
		"updated_at": "2025-08-16T11:24:12.000000Z",
		"created_at": "2025-08-16T11:24:12.000000Z",
		"id": 2
	}
}


<br>



## 2. Login de Usuário
URL: http://localhost:9000/api/login


Método : POST

Headers : Content-Type : application/json

Body (JSON):

```
{
 "email": "joao@example.com",
 "password": "minhasenha"
}
```

Response:

{
	"message": "Login successful.",
	"token": "2|FuJ26Jz78JbU62eLUGHpT6FYVPd21voucamWjqAU0e988a28"
}

<br>


## 3. Criação de Links

URL: http://localhost:9000/api/links
Método: POST
Headers: Content-Type : application/json
         Authorization : Bearer SEU_TOKEN_GERADO


JSON:

{
  "original_url": "[https://www.google.com](https://www.google.com)"
}


Response:

{
	"message": "Link created successfully.",
	"link": {
		"user_id": 2,
		"original_url": "https:\/\/www.google.com",
		"slug": "JwH8NEBQ",
		"expires_at": null,
		"updated_at": "2025-08-18T01:14:19.000000Z",
		"created_at": "2025-08-18T01:14:19.000000Z",
		"id": 1
	}
}

<br>

## 4. Redirecionamento de Links

URL: http://localhost:9000/api/s/SLUG_GERADO
Método: GET





