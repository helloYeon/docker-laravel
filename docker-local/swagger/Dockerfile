FROM node:10

# アプリケーションディレクトリを作成する
WORKDIR /usr/src/app

# swagger-nodeをグローバルインストールする
RUN npm install swagger -g

RUN swagger project create -f express MX1-CMS
WORKDIR /usr/src/app/MX1-CMS

COPY ./swagger.yaml /usr/src/app/MX1-CMS/api/swagger
COPY ./app.js /usr/src/app/MX1-CMS

# swaggerのサーバを起動
CMD swagger project start -m
