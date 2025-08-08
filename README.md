# Laravel API Log Viewer

## Descrição

Projeto simples feito em Laravel para registrar e visualizar logs de requisições API.  
Suporta bancos MySQL e PostgreSQL, com autenticação por token para proteger os endpoints.  

Ideal para monitoramento rápido e básico de APIs, com funcionalidades de:  

- Registro automático de logs via middleware  
- Visualização e paginação dos logs na interface web  
- Endpoints API para criação, listagem, visualização e exportação de logs (CSV)  
- Documentação Swagger para facilitar integração e entendimento da API  

---

## Tecnologias

- Laravel 8.x  
- PHP 8.2  
- MySQL / PostgreSQL  
- Swagger (via l5-swagger)  
- Bootstrap 5 (front-end simples)  

---

## Funcionalidades

- Registro automático de logs das requisições (IP, método, rota, payload e status HTTP)  
- CRUD básico via API para os logs  
- Middleware de autenticação via token (api.token)  
- Exportação dos logs em CSV  
- Documentação da API com Swagger UI  
- Interface web simples para visualização e criação manual dos logs  

---

## Requisitos

- PHP 8.1 ou superior  
- Composer  
- MySQL ou PostgreSQL  
- Extensões PHP: pdo_mysql, pdo_pgsql, json, mbstring  

---

## Instalação

1. Clone o repositório:  

    ```bash
    git clone https://github.com/caioeduardoit/laravel-api-log-viewer.git
    cd laravel-api-log-viewer
    ```

2. Instale as dependências:

    ```bash
    composer install
    ```

3. Configure o arquivo .env com seus dados de banco e chave de API:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=seu_banco
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha

    API_TOKEN=seu_token_secreto
    ```

4. Gere a chave de aplicação:

    ```bash
    php artisan key:generate
    ```

5. Execute as migrations:

    ```bash
    php artisan migrate
    ```

6. (Opcional) Gere a documentação Swagger:

    ```bash
    php artisan l5-swagger:generate
    ```

7. Rode o servidor local:

    ```bash
    php artisan serve
    ```

## Uso

- Acesse a interface web:
  `http://localhost:8000`
- Utilize os endpoints da API protegidos pelo token:
  - `GET /api/logs` - lista logs (aceita filtros via query string)
  - `GET /api/logs/{id}` - detalhes de um log
  - `POST /api/logs` - cria um log (JSON com ip, method, route e payload)
  - `GET /api/logs/export` - exporta logs em CSV ou JSON
- Para autenticação, use o header:

    ```makefile
    Authorization: Bearer seu_token_secreto
    ```

- Documentação Swagger (atualmente acessível, mas com ajustes em desenvolvimento):
  `http://localhost:8000/api/documentation`

## Considerações técnicas

- Middleware customizado para registrar logs automaticamente em todas as requisições à API.
- Compatibilidade com MySQL e PostgreSQL garantida nas migrations e consultas.
- API protegida via middleware `api.token` que valida token configurado no `.env`.
- Exportação CSV ou JSON gerada sob demanda via endpoint.
- Documentação gerada com [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger).

## Como contribuir

Pull requests são bem-vindos! Sinta-se livre para abrir issues para bugs ou sugestões.

## Autor

Caio Eduardo - [GitHub](https://github.com/caioeduardoit)

## Licença

Esse projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE] para detalhes.
