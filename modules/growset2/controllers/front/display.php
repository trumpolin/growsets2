<?php
class Growset2DisplayModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        Tools::redirect($this->module->getPathUri() . 'assets/index.html');
    }
}
