FROM php:7.4-cli

RUN apt update -y \
    && apt install -y libonig-dev \
    && apt clean
