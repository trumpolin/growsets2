<?php

namespace Growset2\Controller\Admin;

use ModuleAdminController;
use Symfony\Component\Process\Process;

class SyncProductsController extends ModuleAdminController
{
    public function initContent()
    {
        parent::initContent();
        $this->executeSync();
        if (empty($this->errors)) {
            $this->content = '<p>Sync triggered.</p>';
            $this->context->smarty->assign('content', $this->content);
        }
    }

    protected function executeSync(): void
    {
        $console = _PS_ROOT_DIR_ . '/bin/console';
        $process = new Process(['php', $console, 'growset2:sync']);
        $process->setTimeout(null);
        $process->disableOutput();

        try {
            $process->start();
        } catch (\Throwable $e) {
            $message = sprintf('Sync command failed to start: %s', $e->getMessage());
            $this->errors[] = $message;
            if (class_exists('\\PrestaShopLogger')) {
                \PrestaShopLogger::addLog($message, 3);
            }
        }
    }
}

