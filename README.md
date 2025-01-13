<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

```markdown
# MDAPI - Application Setup

This document provides detailed instructions to set up and run the MDAPI application using Docker and Laravel.

## Prerequisites

Ensure you have the following installed on your system:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- A modern web browser

---

## Services Overview

### Docker Compose Services

- **app**: PHP application running Laravel.
- **webserver**: Nginx server for handling HTTP requests.
- **mysql**: MySQL database for storing application data.
- **minio**: S3-compatible object storage for file uploads.
- **redis**: In-memory data store used for caching and queues.

---

## Installation Steps

### 1. Clone the Repository

```bash
git clone <repository-url>
cd mdapi
```

### 2. Set Up the Environment File

Create an `.env` file by copying the example:

```bash
cp .env.example .env
```

Edit the `.env` file to set up the necessary configurations:

- Database:
  ```dotenv
  DB_CONNECTION=mysql
  DB_HOST=mdapi-mysql
  DB_PORT=3306
  DB_DATABASE=mdapi
  DB_USERNAME=mdapi_user
  DB_PASSWORD=mdapi_password
  ```

- MinIO:
  ```dotenv
  FILESYSTEM_DISK=s3
  AWS_ACCESS_KEY_ID=minioadmin
  AWS_SECRET_ACCESS_KEY=minioadmin
  AWS_BUCKET=mdapi-bucket
  AWS_ENDPOINT=http://mdapi-minio:9000
  ```

- Mail:
  ```dotenv
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.mailosaur.net
  MAIL_PORT=587
  MAIL_USERNAME=gwrqme3x@mailosaur.net
  MAIL_PASSWORD=Acelot.170510
  MAIL_FROM_ADDRESS=no-reply@seusistema.com
  MAIL_FROM_NAME="Teste de Sistema"
  ```

### 3. Build and Start Services

Run the following command to build and start all Docker services:

```bash
docker-compose up -d
```

### 4. Install PHP Dependencies

Run the following command to install Laravel dependencies inside the `app` container:

```bash
docker exec -it mdapi-app composer install
```

### 5. Set Application Key

Generate the application key:

```bash
docker exec -it mdapi-app php artisan key:generate
```

### 6. Run Database Migrations

Run the migrations to set up the database schema:

```bash
docker exec -it mdapi-app php artisan migrate
```

### 7. Access the Application

Open your browser and navigate to:

```
http://localhost:8044
```

---

## File Storage

- Files are stored in MinIO and can be accessed via:
  - API Endpoint: `http://localhost:9003`
  - Console: `http://localhost:9004`
  - Credentials:
    - **Access Key**: `minioadmin`
    - **Secret Key**: `minioadmin`

---

## Queue Management

The application uses Redis for managing queues. Start the queue worker using:

```bash
docker exec -it mdapi-app php artisan queue:work
```

---

## Testing

### PHPUnit Tests

Run the test suite using:

```bash
docker exec -it mdapi-app php artisan test
```

Ensure your `.env.testing` file is properly configured for SQLite:

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

---

## Troubleshooting

### Common Issues

1. **Database connection error:**
   Ensure the MySQL service is running, and the `.env` configurations are correct.

2. **File upload issues:**
   Ensure MinIO is running and accessible via `http://localhost:9003`.

3. **Queue not processing jobs:**
   Verify the Redis service is running and execute the queue worker command.

---

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

---

## Contributions

Feel free to fork the repository and submit pull requests for improvements!
```

