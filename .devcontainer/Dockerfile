FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteractive

# Installer PHP, Composer, Node.js, SQLite
RUN apt-get update && \
    apt-get install -y software-properties-common curl unzip git sqlite3 && \
    add-apt-repository ppa:ondrej/php -y && \
    apt-get update && \
    apt-get install -y \
        php8.1 \
        php8.1-cli \
        php8.1-mbstring \
        php8.1-xml \
        php8.1-bcmath \
        php8.1-curl \
        php8.1-sqlite3 \
        php8.1-zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

# Utilisateur par défaut
RUN useradd -ms /bin/bash vscode
USER vscode
WORKDIR /workspace
