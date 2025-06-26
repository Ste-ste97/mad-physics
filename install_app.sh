#!/bin/bash
echo -n "This script is about to rebuild the project. All data will be lost are you sure? (y/n)"
read answer
if [ "$answer" != "${answer#[Yy]}" ] ;then
    cp .env.example .env
    # check if .env file not contains DOCKER_UID
    if ! grep -q "DOCKER_UID" .env; then
        echo "DOCKER_UID=$(id -u)" >> .env
    fi
    # check if .env file not contains DOCKER_USER
    if ! grep -q "DOCKER_GID" .env; then
        echo "DOCKER_GID=$(id -g)" >> .env
    fi
    docker compose build --no-cache
    docker compose up -d
    echo "Done with docker"
    sudo chmod u+x composer.sh
    ./composer.sh install
    sudo chmod o+w -R storage/
    sudo chmod u+x artisan.sh
    ./artisan.sh key:generate
    # wait for mysql to start
    sleep 30
    ./artisan.sh migrate:fresh --seed
    echo "Done with everything, enjoy!"
else
    echo "Okay bye!"
fi
