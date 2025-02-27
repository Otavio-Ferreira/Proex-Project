<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Instruções de inicialização:

### Após ter feito o clone do repositório, acesse a pasta do projeto:
```sh
cd app-laravel
```

### Instale as dependências do Composer dentro do projeto:
```sh
composer install
```
### Crie um arquivo .env a partir do arquivo .env.example
```sh
cp .env.example .env
```

### No arquivo .env substitua as configurações de conexão do banco de dados para:
```sh
DB_CONNECTION=sqlite
```

### Crie uma conta no mailtrap.io para gerar as credenciais para receber os emails e cole no arquivo .env:
```sh
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
```

### Atualize seu .env para fazer upload na pasta public:
```sh
FILESYSTEM_DISK=public
```

### Gere a key do projeto laravel:
```sh
php artisan key:generate
```

### Ainda dentro do terminal rode o comando para criar as migrations do banco de dados:
```sh
php artisan migrate --seed
```

### Para usar o storage do laravel e permitir anexos das imagens, rode esse comando:
```sh
php artisan storage:link
```

### Para inicializar os listeners abra um terminal em rode:
```sh
php artisan queue:listen
```

### Para inicializar o servidor e rodar o projeto rode:
```sh
php artisan serve
```
### Instruções do banco de dados:

```mermaid
erDiagram
    USERS ||..|| MODEL_HAS_ROLES : Tem
    USERS ||..|{ MODEL_HAS_PERMISSIONS : Tem
    USERS ||..|| TOKENS : Tem
    MODEL_HAS_ROLES }|..|| ROLES : Tem
    MODEL_HAS_PERMISSIONS }|..|| PERMISSIONS : Tem
    ROLES ||..|{ ROLES_HAS_PERMISSIONS : Tem
    ROLES_HAS_PERMISSIONS }|..|| PERMISSIONS : Tem
    FORMS ||..|{ RESPONSE_FORMS :Tem
    RESPONSE_FORMS ||..|{ ACTIVITYS :Tem
    RESPONSE_FORMS ||..|{ EXTERNAL_PARTNERS:Tem
    RESPONSE_FORMS ||..|{ INTERNAL_PARTNERS :Tem
    RESPONSE_FORMS ||..|{ EXTENSION_ACTIONS :Tem
    RESPONSE_FORMS ||..|{ SOCIAL_MEDIA :Tem
    RESPONSE_FORMS ||..|{ IMAGES :Tem
    RESPONSE_FORMS ||..|{ USERS :Tem

    COURSES{
        ID UUID PK
        NAME TEXT
    }
    PROJECTS{
        ID UUID PK
        TITLE TEXT
    }

    USERS {
        ID UUID PK
        NAME TEXT
        EMAIL TEXT
        PASSWORD TEXT
        STATUS BOOLEAN
    }

    TOKENS {
        ID UUID PK
        TYPE TEXT
        STATUS BOOLEAN
    }

    FORMS {
        ID UUID PK
        TITLE TEXT
        DATE DATE
        STATUS BOOLEAN
    }

    RESPONSE_FORMS {
        ID UUID PK
        FORMS_ID UUID FK
        USER_ID UUID FK
        TITLE_ACTION TEXT
        TYPE_ACTION TEXT
        ACTION_MODALITY TEXT
        CORDINATOR_NAME TEXT
        CORDINATOR_PROFILE TEXT
        CORDINATOR_SIAPE TEXT
        COORDINATOR_COURSE TEXT
        QTD_INTERNAL_AUDIENCE INT
        QTD_EXTERNAL_AUDIENCE INT
        ADVANCES_EXTENSIONIST_ACTION TEXT
        SOCIAL_TECHNOLOGY_DEVELOPMENT TEXT
        INSTRUMENT_AVALIATION TEXT
    }

    ACTIVITYS{
        ID UUID PK
        RESPONSE_FORMS_ID UUID FK
        ACTIVITY TEXT
        ADDRESS TEXT
    }

    
    INTERNAL_PARTNERS{
        ID UUID PK
        RESPONSE_FORMS_ID UUID FK
        TITLE_PARTNER TEXT
    }

    EXTERNAL_PARTNERS{
        ID UUID PK
        RESPONSE_FORMS_ID UUID FK
        NAME_PARTNER TEXT
        INSTITUTION_TYPE TEXT
        PARTNERSHIP_TYPE TEXT 
    }

    EXTENSION_ACTIONS{
        TITLE_ACTION TEXT
        ID UUID PK
        RESPONSE_FORMS_ID UUID FK
        ITS_FOR_PUBLIC_SCHOOLS BOOLEAN
        INTERNATIONAL_DESCRIPTION TEXT
    }

    SOCIAL_MEDIA{
        ID UUID PK
        RESPONSE_FORMS_ID UUID FK
        NAME TEXT
        LINK TEXT
    }

    IMAGES{
        ID UUID PK
        RESPONSE_FORMS_ID UUID FK
        IMAGE TEXT
        ADDRESS TEXT
        DATE DATE
        DESCRIPTION TEXT
    }
```