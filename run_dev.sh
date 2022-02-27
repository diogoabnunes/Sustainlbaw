DOCKER_USERNAME=lbaw2144 # Replace by your docker hub username
IMAGE_NAME=lbaw2144-piu

docker run -it -p 8000:80 -v $PWD/html:/var/www/html $DOCKER_USERNAME/$IMAGE_NAME
