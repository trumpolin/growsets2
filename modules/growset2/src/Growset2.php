<?php

namespace Growset2;

use Cache;
use Configuration;
use Module;
use Tools;

class Growset2 extends Module
{
    public const CONFIG_CATEGORY_IDS = 'GROWSET2_CATEGORY_IDS';
    public const CONFIG_BACKEND_URL = 'GROWSET2_BACKEND_URL';
    public const CONFIG_TOKEN = 'GROWSET2_BACKEND_TOKEN';
    public const LEGACY_CONFIG_CATEGORY_IDS = 'GROWSET_CATEGORY_IDS';
    public const LEGACY_CONFIG_BACKEND_URL = 'GROWSET_BACKEND_URL';
    public const LEGACY_CONFIG_TOKEN = 'GROWSET_BACKEND_TOKEN';

    public function __construct()
    {
        $this->name = 'growset2';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Growset2';
        $this->need_instance = 0;

        parent::__construct();

        $this->migrateLegacyConfiguration();

        $this->displayName = $this->l('Growset2');
        $this->description = $this->l('Synchronizes products with the Growset2 backend.');
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('actionProductAdd')
            && $this->registerHook('actionProductUpdate')
            && $this->registerHook('actionProductDelete');
    }

    public function uninstall()
    {
        Configuration::deleteByName(self::CONFIG_CATEGORY_IDS);
        Configuration::deleteByName(self::CONFIG_BACKEND_URL);
        Configuration::deleteByName(self::CONFIG_TOKEN);
        Configuration::deleteByName(self::LEGACY_CONFIG_CATEGORY_IDS);
        Configuration::deleteByName(self::LEGACY_CONFIG_BACKEND_URL);
        Configuration::deleteByName(self::LEGACY_CONFIG_TOKEN);

        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submitGrowset2')) {
            Configuration::updateValue(self::CONFIG_CATEGORY_IDS, Tools::getValue(self::CONFIG_CATEGORY_IDS));
            Configuration::updateValue(self::CONFIG_BACKEND_URL, Tools::getValue(self::CONFIG_BACKEND_URL));
            Configuration::updateValue(self::CONFIG_TOKEN, Tools::getValue(self::CONFIG_TOKEN));
            Configuration::deleteByName(self::LEGACY_CONFIG_CATEGORY_IDS);
            Configuration::deleteByName(self::LEGACY_CONFIG_BACKEND_URL);
            Configuration::deleteByName(self::LEGACY_CONFIG_TOKEN);
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
        $helper->submit_action = 'submitGrowset2';
        $helper->currentIndex = \AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = \Tools::getAdminTokenLite('AdminModules');
        $helper->default_form_language = $defaultLang;

        $helper->fields_value[self::CONFIG_CATEGORY_IDS] = $this->getConfigValue(
            self::CONFIG_CATEGORY_IDS,
            self::LEGACY_CONFIG_CATEGORY_IDS,
            'GROWSET2_CATEGORY_IDS',
            'GROWSET_CATEGORY_IDS'
        );
        $helper->fields_value[self::CONFIG_BACKEND_URL] = $this->getConfigValue(
            self::CONFIG_BACKEND_URL,
            self::LEGACY_CONFIG_BACKEND_URL,
            'GROWSET2_BACKEND_URL',
            'GROWSET_BACKEND_URL'
        );
        $helper->fields_value[self::CONFIG_TOKEN] = $this->getConfigValue(
            self::CONFIG_TOKEN,
            self::LEGACY_CONFIG_TOKEN,
            'GROWSET2_BACKEND_TOKEN',
            'GROWSET_BACKEND_TOKEN'
        );

        return $helper->generateForm($fieldsForm);
    }

    private function migrateLegacyConfiguration(): void
    {
        if (!class_exists('Configuration')) {
            return;
        }
        if (!Configuration::get(self::CONFIG_CATEGORY_IDS) && Configuration::get(self::LEGACY_CONFIG_CATEGORY_IDS)) {
            Configuration::updateValue(self::CONFIG_CATEGORY_IDS, Configuration::get(self::LEGACY_CONFIG_CATEGORY_IDS));
        }
        if (!Configuration::get(self::CONFIG_BACKEND_URL) && Configuration::get(self::LEGACY_CONFIG_BACKEND_URL)) {
            Configuration::updateValue(self::CONFIG_BACKEND_URL, Configuration::get(self::LEGACY_CONFIG_BACKEND_URL));
        }
        if (!Configuration::get(self::CONFIG_TOKEN) && Configuration::get(self::LEGACY_CONFIG_TOKEN)) {
            Configuration::updateValue(self::CONFIG_TOKEN, Configuration::get(self::LEGACY_CONFIG_TOKEN));
        }
    }

    private function getConfigValue(string $key, string $legacyKey, string $envKey, string $legacyEnvKey)
    {
        return Configuration::get($key)
            ?: Configuration::get($legacyKey)
            ?: getenv($envKey)
            ?: getenv($legacyEnvKey);
    }

    private function clearProductCache(): void
    {
        Cache::clean('growset2_products');
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
}

