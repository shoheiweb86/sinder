FROM php:8.2-fpm as php82

ENV TZ=Asia/Tokyo

COPY --from=composer /usr/bin/composer /usr/bin/composer

# 依存パッケージのインストール
RUN apt-get update && \
    apt-get install -y git unzip libzip-dev libjpeg-dev libicu-dev libonig-dev nodejs npm \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev zlib1g-dev libwebp-dev && \
    # gdの設定とインストール
    docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/ --with-webp && \
    docker-php-ext-install intl pdo_mysql zip bcmath gd sockets exif && \
    # 不要なパッケージの削除
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# nodeのバージョンをUP
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt update && apt install -y nodejs

COPY ./infra/app/php.ini /usr/local/etc/php/php.ini

# コンテナ内で使えるalias
COPY ./infra/app/alias.sh /root/alias.sh
RUN echo "source ~/alias.sh" >> ~/.bashrc