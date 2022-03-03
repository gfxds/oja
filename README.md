# Task:
Implement a user registration page with an appropriate styling that takes the following
details from the user:

* Email (mandatory)
* Password (mandatory, min of 8 characters, must be a combination of uppercase
letter, lowercase letter and a number)
* Name (optional)
* Postcode (optional)

Implement an API in PHP that takes in the user details mentioned above and persists in local
memory.

The PHP service should expose the endpoints to return the details of all the registered users
and a specific user based on some key.

Notes:
* Include clear instructions about how to run the application for testing purpose
* Please ensure that your solution is properly tested and is of production quality
* You can either share a repository link with the solution or send a zip file
* Please document any relevant information or assumptions you make along the way
* If saving in a repository, please keep the commits small and frequent

# Project

Created using Symfony.

Records are saved to SQLlite Database /var/data.db

If site does not display delete old cache files

```
/var/cache/dev
```

Debug is enabled and dev flags set to show errors/debug console,

## Install locally

### Install Symfony CLI tool

Linux/Mac/Windows:
https://symfony.com/download

Check local requirements:

```
symfony check:requirements
```

Prepare project
```
git clone https://github.com/gfxds/oja.git
cd oja
composer install

```

Run Tests:
```
php ./vendor/bin/phpunit
```

Run Local server:
```
symfony server:start
```

App:
```
http://localhost:8000/
```

Rebuild javascript assets:
```
npm install
npm run build
```

## Routes

HTTP
```
GET  /  - add user form
```

JSON Endpoints

```
GET  /users      - show all users
GET  /users/{id} - show individual users
```

```
PUT/POST  /user - save user

email    string required
password string required
name     string optional
postcode string optional
```
