#!/bin/bash
docker compose exec --user www-data app composer $@
