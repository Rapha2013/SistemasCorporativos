FROM webdevops/php-nginx:8.0-alpine

# Instale os pré-requisitos necessários para ferramentas e extensões instaladas posteriormente.
RUN apk add --update bash gnupg less libpng-dev libzip-dev su-exec unzip

# Recupere o script usado para instalar extensões PHP do contêiner de origem.
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions

# Instale as extensões PHP necessárias e todos os seus pré-requisitos disponíveis via apt.
RUN chmod uga+x /usr/bin/install-php-extensions \
    && sync \
    && install-php-extensions bcmath ds exif gd intl opcache pcntl redis zip

# Copia o binário do Composer da imagem oficial do Docker do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV WEB_DOCUMENT_ROOT /app/public
ENV APP_ENV production
WORKDIR /app
COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN php artisan optimize:clear

RUN chown -R application:application .
