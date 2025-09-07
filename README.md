# Growset2

## Setup

### Backend Module
1. `cd modules/growset2`
2. `composer install`

### Frontend
1. `cd frontend`
2. `npm install`
3. Set `NEXT_PUBLIC_API_BASE` in `.env` to your backend API base URL.

### Docker images
The `docker-compose.yml` configuration uses specific image tags:

- `prestashop/prestashop:8.1`
- `node:18.20`

## Build

Run the frontend build and export. This builds the Next.js frontend and
synchronizes the exported files into the module's `assets` directory:

```bash
cd frontend
npm run build:export
```

The script clears any existing files in `modules/growset2/assets` and then
uses `rsync` to copy the contents of the `out` directory. The module's front
controller loads `assets/index.html` as the entry point.

## Deployment

- Deploy the `modules/growset2` directory into your PrestaShop installation.
- Optionally use `docker-compose up -d` for local development.

## Module Hooks

The Growset2 module registers the following hooks:

- `actionProductAdd`
- `actionProductUpdate`
- `actionProductDelete`

## Cronjob / Queue Examples

### Cronjob
Add the following to your crontab to synchronize products daily at midnight:

```bash
0 0 * * * /path/to/repo/scripts/cron-sync.sh
```

### Queue Worker
Run the queue worker to process sync jobs:

```bash
php scripts/queue-worker.php
```

## Testing

### Backend (PHPUnit)

```
cd modules/growset2
composer test
```

### Frontend (Jest + React Testing Library)

```
cd frontend
npm test
```
