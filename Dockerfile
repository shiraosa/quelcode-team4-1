FROM php:7.3-fpm

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

# composer install
WORKDIR /var/www/html/mycakeapp
RUN composer install
