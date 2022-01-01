# practice-ig-api
The place to study instagram api.

## Usage
You can build the Docker image to test these PHP scripts.

To start
```
docker build -t my-php-app . && \
docker run -d --rm -p 127.0.0.1:8080:80 --name my-running-app my-php-app
```

To stop
```
docker kill my-running-app && \
docker rmi my-php-app
```
