<?php
// Simple queue worker example for product synchronization
while (true) {
    // In a real application, pull job information from a queue system.
    $job = 'sync_products';
    if ($job === 'sync_products') {
        exec('php /var/www/prestashop/bin/console growset:sync');
    }
    sleep(300); // wait 5 minutes before checking again
}
