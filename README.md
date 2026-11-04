# 🥋 EncontreUmJiuJiteiro

<p align="center">
  <strong>Conectando praticantes de Jiu-Jitsu através da localização.</strong>
</p>

<p align="center">
  Encontre pessoas que compartilham a mesma paixão pelo Jiu-Jitsu,
  descubra praticantes próximos e fortaleça a comunidade da arte suave.
</p>

---

## 📖 Sobre o projeto

O **EncontreUmJiuJiteiro** é uma plataforma que tem como objetivo aproximar praticantes de Jiu-Jitsu por meio da localização geográfica.

A proposta é permitir que praticantes encontrem outras pessoas que treinam Jiu-Jitsu nas proximidades, facilitando conexões, amizades, treinos e o fortalecimento da comunidade.

Imagine estar viajando para outra cidade e conseguir descobrir quem treina Jiu-Jitsu naquela região. Ou encontrar pessoas próximas para compartilhar experiências, combinar treinos e ampliar sua rede de contatos dentro do esporte.

É essa experiência que queremos proporcionar.

## 🎯 Objetivos

- 📍 **Descobrir praticantes próximos:** localizar pessoas que praticam Jiu-Jitsu em determinada região.
- 🤝 **Conectar a comunidade:** facilitar o contato entre praticantes.
- 🥋 **Incentivar novos treinos:** aproximar pessoas interessadas em treinar juntas.
- 🌎 **Conectar diferentes regiões:** permitir que praticantes encontrem outros atletas mesmo quando estiverem viajando.
- ⚡ **Localização em tempo real:** possibilitar a visualização de praticantes que optarem por compartilhar sua localização.

## 💡 Como a plataforma pretende funcionar?

A experiência será baseada em localização geográfica e compartilhamento voluntário.

1. O usuário cria sua conta e configura seu perfil.
2. Quando desejar, ativa o compartilhamento de localização.
3. A aplicação recebe as coordenadas geográficas do dispositivo.
4. As coordenadas mais recentes são disponibilizadas para consultas geográficas.
5. Outros usuários podem visualizar praticantes próximos em um mapa.
6. O usuário pode desativar o compartilhamento quando quiser.

## 🚀 Como executar o projeto

Este guia apresenta os passos para configurar e executar o ambiente de desenvolvimento local utilizando Docker.

### 1. Pré-requisitos

Antes de começar, você precisa ter instalado:
- Git.
- Docker Engine.
- Docker Compose Plugin (`docker compose`).

Para verificar se o Docker está instalado:

```bash
docker --version
docker compose version
```

### 2. Clonar o repositório

Clone o projeto:

```bash
git clone https://github.com/JonasMoria/EncontreUmJiuJiteiro.git
```

Entre no diretório:

```bash
cd EncontreUmJiuJiteiro
```

### 3. Configurar as variáveis de ambiente do Docker

Na raiz do projeto, copie o arquivo de exemplo:

```bash
cp .env.example .env
```

O arquivo `.env` contém as configurações utilizadas pelo Docker Compose.

Atualize as permissões do usuário Linux:

```bash
sed -i "s/DOCKER_UID=1000/DOCKER_UID=$(id -u)/" .env
sed -i "s/DOCKER_GID=1000/DOCKER_GID=$(id -g)/" .env
```

Abra o arquivo:

```bash
nano .env
```

Configure as senhas do MySQL e Redis, substituindo os valores de exemplo.

### 4. Construir as imagens Docker

Execute:

```bash
docker compose build
```

Esse comando construirá a imagem da aplicação PHP.

### 5. Instalar o Laravel

O código-fonte da aplicação ficará dentro do diretório `src`.

Crie o diretório, caso ainda não exista:

```bash
mkdir -p src
```

Instale o Laravel utilizando o Composer dentro do container:

```bash
docker compose run --rm --no-deps app composer create-project laravel/laravel .
```

> Se o diretório `src` já possuir uma aplicação Laravel, não execute novamente esse comando.

### 6. Configurar o ambiente Laravel

Copie o arquivo de exemplo criado pelo Laravel:

```bash
cp src/.env.example src/.env
```

Abra o arquivo:

```bash
nano src/.env
```

Configure pelo menos as seguintes variáveis:

```dotenv
APP_NAME=EncontreUmJiuJiteiro
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=jiujiteiro
DB_USERNAME=jiujiteiro
DB_PASSWORD=sua_senha_mysql

REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PASSWORD=sua_senha_redis
REDIS_PORT=6379
```

Utilize os mesmos valores de banco e Redis definidos no `.env` da raiz.

### 7. Gerar a chave da aplicação

Execute:

```bash
docker compose run --rm --no-deps app php artisan key:generate
```

Esse comando gera a chave de criptografia utilizada pelo Laravel.

### 8. Iniciar os containers

Agora inicie os serviços:

```bash
docker compose up -d
```

Para verificar se todos os containers estão funcionando:

```bash
docker compose ps
```

### 9. Executar as migrations

Com os containers em execução:

```bash
docker compose exec app php artisan migrate
```

Pronto! Seu ambiente de desenvolvimento estará disponível.

---

## 🌐 Acessos locais

Após iniciar os containers, você poderá acessar os serviços:

| Serviço | Endereço |
|---|---|
| API Laravel | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |
| Redis Insight | http://localhost:5540 |

As portas podem ser alteradas no `.env` da raiz.

## Qualidade de código — PHP CS Fixer

O projeto utiliza o [PHP CS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) para padronizar automaticamente o código PHP. A configuração fica em `src/.php-cs-fixer.dist.php` e o script de execução em `src/scripts/run-cs-fix.sh`.

### Executar a formatação

Na raiz do repositório, execute:

```bash
composer --working-dir=src cs-fix
```

<p align="center">
  Desenvolvido com 🥋 e tecnologia.
  <br>
  <strong>EncontreUmJiuJiteiro</strong>
</p>
