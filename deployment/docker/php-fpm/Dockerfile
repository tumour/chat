FROM php:7.4-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN apt-get update && apt-get install -y \
     yarn \
     nodejs \
     git \
     zip \
     nano

# Install PDO Mysql
RUN docker-php-ext-install pdo_mysql

# Install ZIP
RUN apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip

RUN useradd -G www-data,root -u 1000 -d /home/chat chat

WORKDIR /var/www

CMD php-fpm

EXPOSE 9000
