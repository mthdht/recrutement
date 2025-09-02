# Utiliser une image PHP 8.2 officielle basée sur Debian Bullseye (OpenSSL 3 compatible)
FROM php:8.2-cli-bullseye

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm \
    zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Créer utilisateur vscode
RUN useradd -ms /bin/bash vscode
USER vscode
WORKDIR /workspace