<?php

namespace Growset;

use Cache;
use Configuration;
use Module;
use Tools;

class Growset extends Module
{
    public const CONFIG_CATEGORY_IDS = 'GROWSET_CATEGORY_IDS';
    public const CONFIG_BACKEND_URL = 'GROWSET_BACKEND_URL';
    public const CONFIG_TOKEN = 'GROWSET_BACKEND_TOKEN';

    public function __construct()
    {
        $this->name = 'growset';
        $this->tab = 'administration';
        $this->version = '1.0.1';
        $this->author = 'Growset';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Growset');
        $this->description = $this->l('Synchronizes products with the Growset backend.');
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('actionProductAdd')
            && $this->registerHook('actionProductUpdate')
            && $this->registerHook('actionProductDelete')
            && $this->registerHook('displayHeader')
            && $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        Configuration::deleteByName(self::CONFIG_CATEGORY_IDS);
        Configuration::deleteByName(self::CONFIG_BACKEND_URL);
        Configuration::deleteByName(self::CONFIG_TOKEN);

        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submitGrowset')) {
            Configuration::updateValue(self::CONFIG_CATEGORY_IDS, Tools::getValue(self::CONFIG_CATEGORY_IDS));
            Configuration::updateValue(self::CONFIG_BACKEND_URL, Tools::getValue(self::CONFIG_BACKEND_URL));
            Configuration::updateValue(self::CONFIG_TOKEN, Tools::getValue(self::CONFIG_TOKEN));
            $output .= $this->displayConfirmation($this->l('Settings updated'));
        }

        return $output . $this->renderForm();
    }

    protected function renderForm()
    {
        $defaultLang = (int) Configuration::get('PS_LANG_DEFAULT');

        $fieldsForm[0]['form'] = [
            'legend' => ['title' => $this->l('Settings')],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Category IDs'),
                    'name' => self::CONFIG_CATEGORY_IDS,
                    'desc' => $this->l('Comma separated category identifiers'),
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Backend URL'),
                    'name' => self::CONFIG_BACKEND_URL,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Backend token'),
                    'name' => self::CONFIG_TOKEN,
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ],
        ];

        $helper = new \HelperForm();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitGrowset';
        $helper->currentIndex = \AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = \Tools::getAdminTokenLite('AdminModules');
        $helper->default_form_language = $defaultLang;

        $helper->fields_value[self::CONFIG_CATEGORY_IDS] = Configuration::get(self::CONFIG_CATEGORY_IDS);
        $helper->fields_value[self::CONFIG_BACKEND_URL] = Configuration::get(self::CONFIG_BACKEND_URL, getenv('GROWSET_BACKEND_URL'));
        $helper->fields_value[self::CONFIG_TOKEN] = Configuration::get(self::CONFIG_TOKEN, getenv('GROWSET_BACKEND_TOKEN'));

        return $helper->generateForm($fieldsForm);
    }

    private function clearProductCache(): void
    {
        Cache::clean('growset_products');
    }

    public function hookActionProductAdd($params)
    {
        $this->clearProductCache();
    }

    public function hookActionProductUpdate($params)
    {
        $this->clearProductCache();
    }

    public function hookActionProductDelete($params)
    {
        $this->clearProductCache();
    }

    public function hookDisplayHeader(array $params = [])
    {
        if (isset($this->context->controller)) {
            $this->context->controller->registerStylesheet(
                'growset-front',
                'modules/' . $this->name . '/assets/app.css',
                ['media' => 'all', 'priority' => 150]
            );

            $this->context->controller->registerJavascript(
                'growset-front',
                'modules/' . $this->name . '/assets/app.js',
                ['position' => 'bottom', 'priority' => 150]
            );
        }
    }

    public function hookDisplayHome(array $params = [])
    {
        return '<div id="growset-app"></div>';
    }
}

