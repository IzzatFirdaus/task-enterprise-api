# Queue Worker Configuration

The system uses the `database` queue driver for audit logs and other background tasks.

## Local Development
To process the queue locally, run the following command in a separate terminal:
```bash
php artisan queue:work
```
For development with automatic code reloading:
```bash
php artisan queue:listen
```

## Production Deployment

### Option 1: Supervisor (Recommended)
Install Supervisor on your Linux server to ensure the queue worker runs continuously.

**Configuration Example (`/etc/supervisor/conf.d/laravel-worker.conf`):**
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/html/storage/logs/worker.log
stopwaitsecs=3600
```

### Option 2: Laravel Horizon
For Redis-backed queues, install Laravel Horizon for a beautiful dashboard and advanced scaling.
1. Install via composer: `composer require laravel/horizon`
2. Install assets: `php artisan horizon:install`
3. Run: `php artisan horizon`

## Monitoring
Check failed jobs using:
```bash
php artisan queue:failed
```
Retry failed jobs:
```bash
php artisan queue:retry all
```
