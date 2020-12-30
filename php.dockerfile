FROM php:7.4-fpm

RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
RUN apt update && apt install -y git zip unzip vim libonig-dev libzip-dev libxml2-dev libgd-dev libpq-dev git

# make install でsudoが使われているのでsudoをインストール
RUN apt install -y sudo

RUN git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis 
RUN docker-php-ext-install pdo_pgsql pgsql mbstring zip xml gd redis



RUN apt install -y mecab libmecab-dev mecab-ipadic-utf8 && \
    cd /usr/local/src && \
    git clone --depth 1 https://github.com/neologd/mecab-ipadic-neologd.git && \
    cd /usr/local/src/mecab-ipadic-neologd && \
    ./bin/install-mecab-ipadic-neologd -n -y && \
    cd /usr/local/src && \
    git clone https://github.com/rsky/php-mecab && \
    cd /usr/local/src/php-mecab/mecab && \
    phpize && ./configure && make && make install && \
    cd /usr/local/etc/php/conf.d && \
    touch ./docker-php-ext-mecab.ini && \
    echo "extension=mecab.so" >> ./docker-php-ext-mecab.ini && \
    echo "mecab.default_dicdir=/usr/lib/mecab/dic/mecab-ipadic-neologd/" >> ./docker-php-ext-mecab.ini





WORKDIR /var/www/html