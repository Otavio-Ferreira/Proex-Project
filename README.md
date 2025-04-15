# Sistema Proex-UFCA

Este repositório contém o código-fonte do Sistema da Proex UFCA. O projeto foi desenvolvido pelo Núcleo de Gestão de Dados da Proex.

## Pré-requisitos

Antes de começar, verifique se você possui o Docker instalado em sua máquina.


## Configuração do Ambiente Docker

1. Clone este repositório em sua máquina usando o seguinte comando:
```bash
git clone https://github.com/Otavio-Ferreira/Proex-Project.git
```
2. Entre no repositorio clonado
```bash
cd Proex-Project/
```
3. Crie o arquivo .env
```bash
cp .env.example .env
```

4. Crie o arquivo docker-compose.yml
```bash
cp docker-compose.yml.dev docker-compose.yml
```

5. No diretório raiz do projeto, execute o seguinte comando para instalar as dependências:
```bash
docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/var/www/html" \
  -w /var/www/html \
  laravelsail/php82-composer:latest \
  composer install --ignore-platform-reqs
``` 
6. Adicione o comando sail ao seu path
```bash
echo "alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'" >> ~/.bashrc && source ~/.bashrc

```
7. Construa a imagem local a partir do Dockerfile
```
sail build
```
8. Inicialize os containers
```bash
sail up -d
```
9. Gere a chave de criptografia do Laravel:
```bash
sail php artisan key:generate
```
10.   Crie um link simbólico para o armazenamento público:
```bash
sail php artisan storage:link
```
<!-- 11.   Instale as dependências do NPM:
```bash
sail npm install
```
11.   Compile os assets:
```bash
sail npm run build
``` -->

12.   Rode as migrations e seeds:
```bash
sail php artisan migrate
sail php artisan db:seed
```

<!-- 13.   Execute a aplicação Laravel Sail:
```bash
sail npm run dev
``` -->
1.  Acesse o sistema através do link: http://localhost:8081


