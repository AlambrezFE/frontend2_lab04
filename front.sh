#!/bin/bash

IMAGE_NAME="dockerfile"

echo "Construyendo la imagen Docker..."
docker build -t $IMAGE_NAME .

docker run -d -p 8000:80 $IMAGE_NAME

echo "Contenedor ejecutándose en http://localhost:8000"

