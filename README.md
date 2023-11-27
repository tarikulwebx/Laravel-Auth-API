<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel-Auth-API

User authentication (Registration, Login, Logout) example of Laravel API using Sanctum.

## Setup

#### Step 1:

Clone the repository in your local directory

```
git clone https://github.com/tarikulwebx/Laravel-Auth-API.git
```

#### Step 2:

Create .env file in your project root directory and copy all liles of codes from .env.example to .env.

Change following database credentails according to your local MySQL Database.

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_auth_api_db
DB_USERNAME=root
DB_PASSWORD=
```

#### Step 3:

Install composer dependencies

```
composer install
```

#### Step 4:

Generate App_key for the Laravel Api (.env file)

```
php artisan key:generate
```

#### Step 5:

Migrate database database

```
php artisan migrate
```

### Step 6:

Run the API

```
php artisan serve
```

### Step 7:

Use Postman to test the API for the register, login and logout process. The working routes are-
Register

```
http://127.0.0.1:8000/api/register
```

Login

```
http://127.0.0.1:8000/api/login
```

Logout

```
http://127.0.0.1:8000/api/logout
```
