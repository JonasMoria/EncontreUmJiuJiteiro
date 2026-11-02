# EncontreUmJiuJiteiro API — ambiente Docker

Ambiente local com Laravel/PHP-FPM, Nginx, MySQL, Redis, phpMyAdmin e Redis Insight.

## Requisitos

- Ubuntu 24.04
- Docker Engine
- Docker Compose plugin (`docker compose`)
- Git

## 1. Preparar variáveis do Docker

Na raiz do projeto:

```bash
cp .env.docker.example .env
nano .env
```

Ajuste `DOCKER_UID` e `DOCKER_GID` com os valores retornados por:

```bash
id -u
id -g
```

Use esses valores para que os arquivos criados pelo PHP/Composer no container pertençam ao seu usuário Linux. Se seus IDs forem diferentes de 1000, atualize o `.env` antes de construir a imagem.

Troque também as senhas de desenvolvimento do MySQL e Redis.

## 2. Criar o diretório da aplicação

```bash
mkdir -p src
```

## 3. Construir as imagens

```bash
docker compose build
```

## 4. Criar o projeto Laravel

O comando abaixo executa o Composer no container usando o UID/GID configurado:

```bash
docker compose run --rm --no-deps app composer create-project laravel/laravel .
```

Se `src` já contiver uma aplicação Laravel, não execute esse comando.

## 5. Configurar o Laravel

```bash
cp src/.env.example src/.env
```

No arquivo `src/.env`, configure:

```dotenv
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=jiujiteiro
DB_USERNAME=jiujiteiro
DB_PASSWORD=local_mysql_password

REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PASSWORD=local_redis_password
REDIS_PORT=6379
```

Use exatamente as senhas definidas no `.env` da raiz.

Gere a chave e execute as migrations:

```bash
docker compose run --rm --no-deps app php artisan key:generate
docker compose up -d
docker compose exec app php artisan migrate
```

Se o Laravel instalado trouxer variáveis adicionais de cache ou sessão, mantenha-as de acordo com a configuração desejada. Para este ambiente, a conexão Redis está disponível pelo host `redis`.

## 6. Endereços locais

- API: http://localhost:8080
- phpMyAdmin: http://localhost:8081
- Redis Insight: http://localhost:5540

No Redis Insight, adicione uma conexão:
- Host: `redis`
- Port: `6379`
- Username: deixe vazio (usuário default)
- Password: valor de `REDIS_PASSWORD` no `.env` da raiz

No phpMyAdmin, use:
- Servidor: `mysql`
- Usuário: valor de `MYSQL_USER` ou `root`
- Senha: a correspondente no `.env` da raiz

## Comandos úteis

```bash
docker compose up -d
docker compose down
docker compose ps
docker compose logs -f app
docker compose logs -f nginx
docker compose exec app bash
docker compose exec app php artisan migrate
docker compose exec app composer install
```

Para apagar containers e redes, preservando os dados dos volumes:

```bash
docker compose down
```

Para apagar também os dados persistidos de MySQL, Redis e Redis Insight:

```bash
docker compose down -v
```

**Atenção:** `down -v` apaga permanentemente os dados dos volumes deste projeto.

## Observações sobre permissões

- O serviço `app` executa com o UID/GID configurado em `.env`.
- O código é montado em `./src`, portanto permanece na máquina local.
- Não use `sudo` para criar arquivos dentro de `src`.
- Se mudar o UID/GID depois de criar arquivos, talvez seja necessário corrigir a propriedade uma única vez no host.
- O Nginx monta o código como somente leitura.

## Observações de segurança

Este Compose é para desenvolvimento local. As portas do MySQL e Redis são publicadas somente em `127.0.0.1`. Não exponha phpMyAdmin, Redis Insight, MySQL ou Redis diretamente à internet em produção. Use senhas fortes e uma configuração de produção separada.
