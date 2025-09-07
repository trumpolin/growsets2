<?php
/**
 * Front controller that serves the pre-built frontend.
 *
 * The `assets` directory is populated by `npm run build:export` which
 * synchronizes the Next.js export into `modules/growset2/assets`. The
 * generated `index.html` acts as the entry point for the module frontend.
 */
class Growset2DisplayModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        // Redirect to the exported frontend entry point.
        $url = $this->module->getPathUri() . 'assets/index.html';
        header('Location: ' . $url, true, 302);
        exit;
    }
}
