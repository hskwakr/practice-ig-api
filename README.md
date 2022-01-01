# practice-ig-api
The place to study instagram api.

## Usage
You can build the Docker image to test these PHP scripts.

To start
```
docker build -t my-php-app . && \
docker run -d --name my-running-app -p 127.0.0.1:8080:80 --rm my-php-app
```

To stop
```
docker kill my-running-app && \
docker rmi my-php-app
```
