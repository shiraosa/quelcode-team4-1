FROM php:7.3-apache

# ContainerのPortを開放する
EXPOSE 80

# 環境変数を宣言する
ENV MYSQL_DATABASE=docker_db
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_USER=docker_db_user
ENV MYSQL_PASSWORD=docker_db_user_pass
ENV TZ=Asia/Tokyo
ENV DEBUG=0

# 変数を宣言する
ARG DOCKER_UID=${DOCKER_UID}
ARG DOCKER_USER=docker
ARG DOCKER_PASSWORD=docker

# composerをインストールする
RUN curl -s https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

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

# Apache2のModuleを有効化する
RUN a2enmod rewrite

# アプリケーションファイルを追加
ADD html/ /var/www/html

# 設定ファイルを追加
ADD docker/php/php.ini /var/www/docker/php/php.ini
ENV APACHE_DOCUMENT_ROOT /var/www/html/mycakeapp/webroot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# htmlをcopyしてcomposer install用に権限変更
COPY html/ /var/www/html
RUN chmod -R 777 mycakeapp/

# ユーザを作成する
RUN useradd -m ${DOCKER_USER} -u ${DOCKER_UID}
RUN echo "${DOCKER_USER}:${DOCKER_PASSWORD}" | chpasswd

# 作成したユーザのサブグループにsudoを追加する
RUN usermod -aG sudo ${DOCKER_USER}

# 作成したユーザに切り替える
USER ${DOCKER_USER}

# ComposerをInstallする
WORKDIR /var/www/html/mycakeapp
RUN composer install
