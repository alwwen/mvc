![php code image](/assets/images/php.png)
# MVC
This is my report page using Symfony in the course MVC.

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alwwen/mvc/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/alwwen/mvc/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/alwwen/mvc/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/alwwen/mvc/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/alwwen/mvc/badges/build.png?b=main)](https://scrutinizer-ci.com/g/alwwen/mvc/build-status/main)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/alwwen/mvc/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)

## Installation

### PHP and node
Make sure you have php version 8.3 and have node installed.
You can check these by typing this in the terminal.

#### PHP
```bash
php --version
```
#### node
```bash
node --version
```

### Clone
Afterwards you need to clone this repository.
```bash
git clone https://github.com/alwwen/mvc.git
```
### Install node modules
After you have cloned the repo, be in the terminal in the / folder of the repo.
Then run this:
```bash
npm install
```


## Usage
To use the program without changing anything just run this in the / folder of the repo.
```bash
php -S localhost:8888 -t public
```
If you have change the CSS or added a image, run this line before the server.
```bash
npm run build
```
### Images
As put above. If you want to change the CSS or add an image, you will have to look at the folder called assets. It's from that folder the build command looks and moves the pictures and CSS to the build folder and map it correctly.
