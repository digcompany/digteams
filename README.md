# The Source Code of DigCompany

![Tests](https://github.com/digcompany/digcompany/actions/workflows/test.yml/badge.svg)
![Styling](https://github.com/digcompany/digcompany/actions/workflows/code-formatting.yml/badge.svg)
![Linting](https://github.com/digcompany/digcompany/actions/workflows/phplint.yml/badge.svg)

## Installation

### Install Dependencies

```bash
composer install
```

```bash
npm install && npm run dev
```

### Configure Environment

First copy `.env.example` to `.env`

```bash
cp .env.example .env
```

Then edit database configurations to match your local setup

### Run Migrations

```bash
php artisan migrate:fresh --path=database/migrations/landlord --database=landlord
```

### Then install the icons

```bash
php artisan install:icons
```

### After that is finished you can generate an app key

```bash
php artisan key:generate
```

### Run Tests

```bash
php artisan test
```

### And finally serve your application!

```bash
php artisan serve
```
