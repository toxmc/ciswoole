
ciswoole
========

CodeIgniter 2.2 with Swoole Http_Server
## Requirements

* PHP 5.3+
* Swoole 1.7.8
* Linux, OS X and basic Windows support (Thinks to cygwin)

## Installation Swoole

1. Install via pecl
    
    ```
    pecl install swoole
    ```

2. Install from source

    ```
    sudo apt-get install php5-dev
    git clone https://github.com/swoole/swoole-src.git
    cd swoole-src
    phpize
    ./configure
    make && make install
    ```
## How to run
1. cd ciswoole/server
2. php http_server.php
3. Open your browser and enter http://ip:9501
## Comparison test
1. This is the home page comparison test
![index](https://raw.githubusercontent.com/smalleyes/ciswoole/master/contrast_page.jpg)
2. This is a data query comparison test
![db](https://raw.githubusercontent.com/smalleyes/ciswoole/master/contrast_db.jpg)
## batch test
>压侧对同一个数据库，数据表进行读取操作测试在虚拟机下进行导致QPS两个都很低，主要是比较两种框架在相同模式下性能差别第一个是ciswoole
    ```
	[xmc@localhost ciswoole]$ ab -c500 -n5000 -k http://192.168.1.10:9501/welcome/dbtest
	This is ApacheBench, Version 2.3 <$Revision: 1604373 $>
	Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
	Licensed to The Apache Software Foundation, http://www.apache.org/
	
	Benchmarking 192.168.1.10 (be patient)
	Completed 500 requests
	Completed 1000 requests
	Completed 1500 requests
	Completed 2000 requests
	Completed 2500 requests
	Completed 3000 requests
	Completed 3500 requests
	Completed 4000 requests
	Completed 4500 requests
	Completed 5000 requests
	Finished 5000 requests
	
	
	Server Software:        swoole-http-server
	Server Hostname:        192.168.1.10
	Server Port:            9501
	
	Document Path:          /welcome/dbtest
	Document Length:        1756 bytes
	
	Concurrency Level:      500
	Time taken for tests:   6.077 seconds
	Complete requests:      5000
	Failed requests:        0
	Keep-Alive requests:    5000
	Total transferred:      9625000 bytes
	HTML transferred:       8780000 bytes
	Requests per second:    822.73 [#/sec] (mean)
	Time per request:       607.729 [ms] (mean)
	Time per request:       1.215 [ms] (mean, across all concurrent requests)
	Transfer rate:          1546.65 [Kbytes/sec] received
	
	Connection Times (ms)
	              min  mean[+/-sd] median   max
	Connect:        0    2   6.2      0      28
	Processing:    54  575 128.3    589     896
	Waiting:       54  575 128.3    589     896
	Total:         81  577 124.6    589     896
	
	Percentage of the requests served within a certain time (ms)
	  50%    589
	  66%    624
	  75%    647
	  80%    666
	  90%    721
	  95%    761
	  98%    818
	  99%    843
	 100%    896 (longest request)
    ```
  >结论：这是CodeIgniter 2.2 
    ```		
	[xmc@localhost ciswoole]$  ab -c500 -n 5000 -k http://ci22.iizhu.com/welcome/dbtest
	This is ApacheBench, Version 2.3 <$Revision: 1604373 $>
	Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
	Licensed to The Apache Software Foundation, http://www.apache.org/
	
	Benchmarking ci22.iizhu.com (be patient)
	Completed 500 requests
	Completed 1000 requests
	Completed 1500 requests
	Completed 2000 requests
	Completed 2500 requests
	Completed 3000 requests
	Completed 3500 requests
	Completed 4000 requests
	Completed 4500 requests
	Completed 5000 requests
	Finished 5000 requests
	
	
	Server Software:        nginx/1.6.2
	Server Hostname:        ci22.iizhu.com
	Server Port:            80
	
	Document Path:          /welcome/dbtest
	Document Length:        1756 bytes
	
	Concurrency Level:      500
	Time taken for tests:   35.462 seconds
	Complete requests:      5000
	Failed requests:        313
	   (Connect: 0, Receive: 0, Length: 313, Exceptions: 0)
	Non-2xx responses:      313
	Keep-Alive requests:    313
	Total transferred:      9087643 bytes
	HTML transferred:       8284208 bytes
	Requests per second:    140.99 [#/sec] (mean)
	Time per request:       3546.239 [ms] (mean)
	Time per request:       7.092 [ms] (mean, across all concurrent requests)
	Transfer rate:          250.26 [Kbytes/sec] received
	
	Connection Times (ms)
	              min  mean[+/-sd] median   max
	Connect:        0    3   8.2      0      32
	Processing:   126 2906 4831.2   1116   29236
	Waiting:      126 2906 4831.2   1116   29236
	Total:        154 2909 4835.0   1116   29262
	
	Percentage of the requests served within a certain time (ms)
	  50%   1116
	  66%   2011
	  75%   2090
	  80%   2173
	  90%   5457
	  95%  13938
	  98%  26615
	  99%  26700
	 100%  29262 (longest request)
    ```
  >结论：ciswoole的qps达到822.73 [#/sec] (mean) 而使用nginx+php-fpm的qps只达到140.99 [#/sec] (mean)
不难的出，ciswoole效率比ci+nginx+php-fpm强五倍
