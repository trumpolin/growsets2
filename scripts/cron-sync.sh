#!/usr/bin/env bash
# Example cronjob that triggers product synchronization
php /var/www/prestashop/bin/console growset:sync >> /var/log/growset-sync.log 2>&1
