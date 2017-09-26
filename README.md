# testdkf

Instalación

1. Crear base de datos
2. Actualizar el archivo de configuración

```
cd testdkf
cp app/config/parameters.yml.dist app/config/parameters.yml
```

3. Instalar los vendor

```
cd testdkf
composer install
```

4. Configuración en Nginx

```
server {
    listen 88;

    server_name test.kimia.me;
    root        /var/www/testdkf/web;
    index app.php index.php index.html index.htm;

    location / {
        if (!-f $request_filename) {
            rewrite ^(.+)$ /app_dev.php?XDEBUG_SESSION_START=api last;
            break;
        }
    }

    # DEV
    # This rule should only be placed on your development environment
    # In production, don't include this and don't deploy app_dev.php or config.php
    location ~ ^/(app_dev|config)\.php(/|$) {
        fastcgi_pass unix:/run/php/php7.1-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param HTTPS off;
    }

    # PROD
    location ~ ^/app\.php(/|$) {
        fastcgi_pass unix:/run/php/php7.1-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param HTTPS off;
    }

    error_log /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
}
```