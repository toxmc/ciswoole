
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

	1. See document file ab_batch.txt
