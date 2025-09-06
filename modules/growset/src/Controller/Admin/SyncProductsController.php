<?php

namespace Growset\Controller\Admin;

use ModuleAdminController;

class SyncProductsController extends ModuleAdminController
{
    public function initContent()
    {
        parent::initContent();
        $this->executeSync();
        $this->content = '<p>Sync triggered.</p>';
        $this->context->smarty->assign('content', $this->content);
    }

    protected function executeSync(): void
    {
        $cmd = _PS_ROOT_DIR_ . '/bin/console growset:sync';
        if (function_exists('exec')) {
            @exec('php ' . escapeshellcmd($cmd) . ' > /dev/null 2>&1 &');
        }
    }
}

