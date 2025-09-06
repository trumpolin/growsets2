# Growsets

## Setup

### Backend Module
1. `cd modules/growset`
2. `composer install`

### Frontend
1. `cd frontend`
2. `npm install`

## Build

- `cd frontend && npm run build:export`
- Generated assets will be copied to `modules/growset/assets`.

## Deployment

- Deploy the `modules/growset` directory into your PrestaShop installation.
- Optionally use `docker-compose up -d` for local development.

## Module Hooks

The Growset module registers the following hooks:

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
cd modules/growset
composer test
```

### Frontend (Jest + React Testing Library)

```
cd frontend
npm test
```
