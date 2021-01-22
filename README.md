# quelcode-team4-1
チーム ゴースト・プロトコル

アプリケーション
http://codegym-isa-team-4-1.eba-wu5xj37f.ap-northeast-1.elasticbeanstalk.com/QuelCinemas

ドキュメント
- 基本設計書　https://docs.google.com/presentation/d/1OKQ1Ugwr726bUHO6eZ_eljyP5Hrl0UiRytRF7WDL-9k/edit#slide=id.p
- ドキュメント　https://docs.google.com/document/d/1I0GWjLoWSVDA0OHvQxLrpPRYHHj0oaqmUnxIZwweMW8/edit
- データベース定義書　https://docs.google.com/spreadsheets/d/1eX-e9BiFSAPeDv_hHFntLQgzdf3XNp47EeiSwXu89g8/edit#gid=814062845
- タスク管理（Jira）　https://quelcode-teamdev4.atlassian.net/jira/software/projects/TEAM1/boards/5/backlog?issueParent=0
- 画面遷移図　https://docs.google.com/drawings/d/1my3T3d2a3bUKHNLo6-PeGjnocFeb7LuiffK--GNIn9s/edit

- CakePHP3 映画予約システム docker 環境

## docker 起動前の準備

- docker/php/Dockerfile の DOCKER_UID をホストと合わせる

  ```
  # ホストのuidを調べる
  id -u

  # docker/php/Dockerfile の ARG DOCKER_UID=1000 の右辺を↑で調べた値にする
  vim docker/php/Dockerfile
  ```

  - Linux ではこれをやらないとゲスト側で作成したファイルをホスト側で編集できなくなる
  - Mac ではこの手順は不要との説もある
  - Windows の人は WSL (Windows Subsystem for Linux) を使おう

## docker の起動方法

- docker-compose.yml がある場所で下記のコマンドを実行する。初回起動には時間がかかる

  ```
  docker-compose up -d
  ```

## docker の終了方法

- docker-compose.yml がある場所で下記のコマンドを実行する

  ```
  docker-compose down
  ```

## 起動中のコンテナの bash を実行する方法(重要)

- php コンテナの場合

  ```
  docker-compose exec php bash
  ```

  - php コンテナの bash では composer コマンドや ./bin/cake ファイルが実行可能です！

- msyql コンテナの場合

  ```
  docker-compose exec mysql bash
  ```

  - mysql コマンドラインの起動方法

    ```
    # mysql コンテナの bash で
    mysql -u root -p # パスワードは"root"
    ```

## 起動中のコンテナの bash を終了する方法

- コンテナの bash で下記のショートカットキーを入力する

  ```
  ctrl + p + q
  ```

  - コンテナの bash で exit コマンドを打つとコンテナ自体が終了してしまう恐れがある

## php コンテナに cakephp をインストールする方法

- php コンテナの bash で /var/www/html/mycakeapp に移動して

  ```
  composer install
  ```

  - 時間がかかる。質問プロンプトが出たら Y と回答する

    ```
    Set Folder Permissions ? (Default to Y) [Y,n]? Y
    ```

## migration

- php コンテナの bash で /var/www/html/mycakeapp に移動して

  ```
  ./bin/cake migrations migrate
  ```


## ブラウザで phpMyAdmin を表示する方法

- http://localhost:10381 にアクセスする
  - root 権限で操作可能


## docker network 上での DB 接続情報

- docker-compose.yml を参照
  - DB ホスト: mysql
  - mysql の port: 3306
  - MYSQL_DATABASE: docker_db
  - MYSQL_ROOT_PASSWORD: root
  - MYSQL_USER: docker_db_user
  - MYSQL_PASSWORD: docker_db_user_pass
