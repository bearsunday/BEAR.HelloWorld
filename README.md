# BEAR.HelloWorld
Hello World benchmarking for BEAR.Sunday

## Installation
Install project
```
git clone https://github.com/bearsunday/BEAR.HelloWorld.git
cd BEAR.HelloWorld
composer install
```
start php server
```
php -S 127.0.0.1:8080 var/www/index.php
```

### test raw page
```
ab -t 10 -c 10 http://127.0.0.1:8080/raw
```

### test @QueryRepository page witout Etag
```
ab -t 10 -c 10 http://127.0.0.1:8080/
```

### test @QueryRepository page with Etag

get etag
```
curl -v http://127.0.0.1:8080/
* Hostname was NOT found in DNS cache
*   Trying 127.0.0.1...
* Connected to 127.0.0.1 (127.0.0.1) port 8080 (#0)
> GET / HTTP/1.1
> User-Agent: curl/7.38.0
> Host: 127.0.0.1:8080
> Accept: */*
> 
< HTTP/1.1 200 OK
< Host: 127.0.0.1:8080
< Connection: close
< X-Powered-By: PHP/5.6.5
< Etag: 2669725389
< Last-Modified: Wed, 11 Mar 2015 01:40:14 GMT
< Content-type: text/html; charset=UTF-8
< 
```
request with `If-None-Match` header
```
ab -t 10 -c 10 http://127.0.0.1:8080/
ab -H "If-None-Match: 2669725389" -t 10 -c 10 http://127.0.0.1:8080/
```
