FROM php:7.3-apache

EXPOSE 80

# 本番環境であることを示す環境変数
ENV CURRENT_ENVIRONMENT=production
ENV DEBUG=0

# 鍵の環境変数（AWS上での操作による設定に切り替える可能性）
ENV DEV_KEY=HOGEhogeHOGEhogeHOGEhogeHOGEhoge

# MySQL用の環境変数
ENV MYSQL_DATABASE=docker_db
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_USER=root
ENV MYSQL_PASSWORD=docker_db_user_pass
ENV TZ=Asia/Tokyo

# composerをインストールする
RUN curl -sS https://getcomposer.org/installer | php -- --version=1.10.15 && mv composer.phar /usr/local/bin/composer

# Node.jsをダウンロードする
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -

# パッケージをインストールする
RUN apt-get update \
  && apt-get install -y git zip unzip \
  && apt-get install -y sudo \
  && apt-get install -y vim \
  && apt-get install -y nodejs \
  && apt-get install -y libicu-dev \
  && docker-php-ext-install pdo_mysql intl mbstring

RUN a2enmod rewrite
# 作業ディレクトリを変更する
WORKDIR /var/www/html/mycakeapp

# アプリケーションファイルを追加
ADD html/ /var/www/html
# 設定ファイルを追加
ADD docker/php/php.ini /var/www/docker/php/php.ini

ENV APACHE_DOCUMENT_ROOT /var/www/html/mycakeapp/webroot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# composerのインストールを行う
RUN composer install
