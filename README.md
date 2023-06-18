# Конфигурации:
### - NGINX
### - APACHE
### - MYSQL
### - PHPMYADMIN
### - NODEJS
### - REDIS
### - MONGO
### - DJANGO
### - FASTAPI
### - FLASK
### - POSTGRES
### - ADMINER

Для запуска контейнера необходимо раскомментировать нужные и выполнить:
docker-compose up --build ('--build' необходим при первом запуске)

## NGINX

### Docker-compose:

    web:
      build: ./nginx
      container_name: learn_nginx
      volumes:
        - ./www/php:/usr/share/nginx/html/www
      restart: unless-stopped
      ports:
        - "8082:80"
      environment:
        - NGINX_HOST=localhost
        - NGINX_PORT=80

### Dockerfile:

    FROM webdevops/php-nginx:8.1-alpine
    COPY nginx.conf /etc/nginx/nginx.conf

nginx.conf - содержит настройки для изменения

http://['Ваш ip']:8082/

http://localhost:8082/

## APACHE

### Docker-compose:

    apache:
      build: ./apache
      container_name: apache
      volumes:
        - ./www/php:/var/www/html
      ports:
        - "8084:80"
      environment:
        WEB_DOCUMENT_ROOT: "/var/www/html"
        WEB_DOCUMENT_INDEX: index.php
        PHP_MEMORY_LIMIT: 1024M
        PHP_UPLOAD_MAX_FILESIZE: 512M
        PHP_POST_MAX_SIZE: 512M
        PHP_DISPLAY_ERRORS: 1
        php.xdebug.max_nesting_level: 500
        XDEBUG_CONFIG: "xdebug.mode=debug"
        XDEBUG_MODE: coverage

### Dockerfile:

    FROM webdevops/php:8.2-alpine
    ENV WEB_DOCUMENT_ROOT=/app \
    WEB_DOCUMENT_INDEX=index.php \
    WEB_ALIAS_DOMAIN=*.vm \
    WEB_PHP_TIMEOUT=600 \
    WEB_PHP_SOCKET=""
    ENV WEB_PHP_SOCKET=127.0.0.1:9000
    COPY conf/ /opt/docker/
    RUN set -x \
    # Install apache
    && apk-install \
    apache2 \
    apache2-ctl \
    apache2-utils \
    apache2-proxy \
    apache2-ssl \
    # Fix issue with module loading order of lbmethod_* (see https://serverfault.com/questions/922573/apache2-fails-to-start-after-recent-update-to-2-4-34-no-clue-why)
    && sed -i '2,5{H;d}; ${p;x;s/^\n//}' /etc/apache2/conf.d/proxy.conf \
    && sed -ri ' \
    s!^(\s*CustomLog)\s+\S+!\1 /proc/self/fd/1!g; \
    s!^(\s*ErrorLog)\s+\S+!\1 /proc/self/fd/2!g; \
    ' /etc/apache2/httpd.conf \
    && docker-run-bootstrap \
    && docker-image-cleanup
    EXPOSE 80 443

http://['Ваш ip']:8084/

http://localhost:8084/

## NODEJS

### Docker-compose:

    nodejs:
      image: node:18-alpine
      container_name: nodejs
      restart: unless-stopped
      ports:
        - "5000:5004"
      volumes:
        - ./www/node:/usr/src/app
      working_dir: /usr/src/app
      command: npm start

Сам NODEJS находится /www/node

/www/node/client содержит React, или можно любой другой framework

http://['Ваш ip']:5000/

http://localhost:5000/

## MYSQL & PHPMYADMIN

### Docker-compose:

    learn_mysql:
      build: ./mysql
      container_name: learn_mysql
      environment:
        MYSQL_ROOT_PASSWORD: masterkey
        MYSQL_DATABASE: learn_mysql
      ports:
        - "3282:3306"
      volumes:
        - learn-db:/var/lib/mysql
    phpmyadmin:
      image: phpmyadmin/phpmyadmin:latest
      restart: always
      ports:
        - '8088:80'
      environment:
        PMA_ARBITRARY: 0
        PMA_HOST: 'learn_mysql'
        MYSQL_ROOT_PASSWORD: 'masterkey'
      depends_on:
        - learn_mysql

### Dockerfile:

    FROM mysql:8.0.31
    COPY ./my.cnf /etc/mysql/my.cnf

mycnf - содержит настройки для изменения

http://['Ваш ip']:8088/

http://localhost:8088/ - PHPMYADMIN

LOGIN: root

PASSWORD: masterkey

### MYSQL

host: ['Ваш ip']

port: 3282

LOGIN: root

PASSWORD: masterkey

## REDIS

### Docker-compose:

    redis:
      image: 'redis:alpine'
      ports:
        - '6379:6379'

host: ['Ваш ip']

port: 6379

## MONGO

### Docker-compose:

    mongo:
      image: mongo:6.0.6
      ports:
        - 27017:27017
      volumes:
        - learn-db:/data/db
      environment:
        MONGO_INITDB_ROOT_USERNAME: root
        MONGO_INITDB_ROOT_PASSWORD: masterkey

host: ['Ваш ip']

port: 27017

LOGIN: root

PASSWORD: masterkey

## POSTGRES

### Docker-compose:

     postgres:
          image: postgres:15.3-alpine
          container_name: postgres
          restart: always
          ports:
            - "5432:5432"
          environment:
            - POSTGRES_USER=root
            - POSTGRES_PASSWORD=masterkey
            - POSTGRES_DB=django_dev
 
host: ['Ваш ip']

port: 5432

LOGIN: root

PASSWORD: masterkey

## PGADMIN4

### Docker-compose:

    pgadmin4:
      image: fenglc/pgadmin4
      container_name: pgadmin4
      restart: always
      volumes:
        - ./postgress:/var/lib/pgadmin
      environment:
          PGADMIN_DEFAULT_EMAIL: pgadmin4@pgadmin.org
          PGADMIN_DEFAULT_PASSWORD: admin
      ports:
        - "5050:5050"

email: pgadmin4@pgadmin.org

password: admin

Create server:

host: ['Ваш ip']

port: 5432

db: django_dev

login: root

password: masterkey

## ADMINER

### Docker-compose:

    adminer:
      image: adminer
      restart: always
      ports:
        - "8086:8080"

http://['Ваш ip']:8086/

http://localhost:8086/

## Django

### Docker-compose:

    django:
      build: ./www/django
      container_name: django
      command: python manage.py runserver 0.0.0.0:8000
      volumes:
        - ./www/django:/usr/src/app/
      ports:
        - "8000:8000"

### Dockerfile

    FROM python:3.10-alpine
    RUN apk update \
    add \
    build-base \
    postgresql \
    postgresql-dev \
    libpq
    RUN mkdir /usr/src/app
    WORKDIR /usr/src/app
    COPY ./requirements.txt .
    RUN pip install -r requirements.txt
    ENV PYTHONUNBUFFERED 1
    COPY . .
    
    CMD ["python", "manage.py", "runserver", "0.0.0.0:8000"]

http://['Ваш ip']:8000/

http://localhost:8000/

## FASTAPI

### Docker-compose:

     fastapi:
       build: ./www/fastapi
       container_name: fastapi
       ports:
         - "8000:8000"
       volumes:
         - ./www/fastapi:/code

### Dockerfile

    FROM python:3.10-alpine
    # Устанавливаем переменные окружения
    ENV PYTHONDONTWRITEBYTECODE 1
    ENV PYTHONUNBUFFERED 1
    # Устанавливаем рабочую директорию внутри контейнера
    WORKDIR /app
    # Копируем зависимости в контейнер
    COPY requirements.txt /app/
    # Устанавливаем зависимости
    RUN pip install --no-cache-dir -r requirements.txt
    # Копируем остальные файлы в контейнер
    COPY . /app/
    # Указываем команду, которая будет выполняться при запуске контейнера
    CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000"]

http://['Ваш ip']:8000/

http://localhost:8000/

## FLASK

### Docker-compose:

     flask:
       build: ./www/flask
       container_name: flask
       ports:
         - "5000:5000"
       volumes:
         - ./www/flask:/app

### Dockerfile

    FROM python:3.10-alpine
    # Устанавливаем рабочую директорию внутри контейнера
    WORKDIR /app
    # Копируем файлы зависимостей в контейнер
    COPY requirements.txt .
    # Устанавливаем зависимости
    RUN pip install --no-cache-dir -r requirements.txt
    # Копируем остальные файлы проекта в контейнер
    COPY . .
    # Указываем переменные окружения
    ENV FLASK_APP=app.py
    ENV FLASK_RUN_HOST=0.0.0.0
    # Открываем порт, на котором будет работать приложение
    EXPOSE 5000
    # Запускаем команду для запуска Flask приложения
    CMD ["flask", "run"]

http://['Ваш ip']:5000/

http://localhost:5000/
