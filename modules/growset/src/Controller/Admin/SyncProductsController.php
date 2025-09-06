<?php

namespace Growset\Controller\Admin;

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
        $process = new Process(['php', $console, 'growset:sync']);
        $process->run();

        if (!$process->isSuccessful()) {
            $message = sprintf(
                'Sync command failed with code %d: %s',
                $process->getExitCode(),
                trim($process->getErrorOutput())
            );
            $this->errors[] = $message;
            if (class_exists('\\PrestaShopLogger')) {
                \PrestaShopLogger::addLog($message, 3);
            }
        }
    }
}

