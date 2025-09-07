#!/usr/bin/env bash
# Example cronjob that triggers product synchronization
php /var/www/prestashop/bin/console growset2:sync >> /var/log/growset2-sync.log 2>&1
