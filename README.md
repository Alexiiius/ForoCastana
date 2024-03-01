- Alejandro Sánchez
- 2º DAW
- Last push 1/3/2024


# Chestnut Forum

A simple web forum about chestnuts made with Laravel! Feel free to talk with others about the fantastic world of chestnuts.

## Contents

- [Requirements](#requirements)
- [Installation](#installation)

## Requirements

- PHP >= 7.3
- Composer
- Node.js & npm
- Docker & Docker Compose (for Laravel Sail)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/chestnut-forum.git
cd chestnut-forum
```

2. Install PHP dependencies:
```bash
./vendor/bin/sail composer install
```

3. Install JavaScript dependencies:
```bash
./vendor/bin/sail npm install
```
4. Copy the example environment file and modify according to your environment:
```bash
cp .env.example .env
```
5. Start the Laravel Sail environment:
```bash
./vendor/bin/sail up -d
```
6. Generate the application key:
```bash
./vendor/bin/sail artisan key:generate
```
7. Run the database migrations:
```bash
./vendor/bin/sail artisan migrate
```
8. Seed the database with some data:
```bash
./vendor/bin/sail artisan db:seed
```
9. Create a symbolic link from `public/storage` to `storage/app/public`:
```bash
./vendor/bin/sail artisan storage:link
```
10. Compile your assets:
```bash
npm run dev
```
Now, you should be able to visit the application in your web browser by visiting http://localhost.



