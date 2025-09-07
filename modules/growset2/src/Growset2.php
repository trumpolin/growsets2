<?php

namespace Growset2;

use Cache;
use Category;
use Configuration;
use Module;
use Tools;

class Growset2 extends Module
{
    public const CONFIG_GROWBOX_CATEGORY = 'GROWSET2_GROWBOX_CATEGORY_ID';
    public const CONFIG_GROWLED_CATEGORY = 'GROWSET2_GROWLED_CATEGORY_ID';
    public const CONFIG_ABLUFT_VENTILATOR_CATEGORY = 'GROWSET2_ABLUFT_VENTILATOR_CATEGORY_ID';
    public const CONFIG_AKTIVKOHLEFILTER_CATEGORY = 'GROWSET2_AKTIVKOHLEFILTER_CATEGORY_ID';
    public const CONFIG_ABLUFTSCHLAUCH_CATEGORY = 'GROWSET2_ABLUFTSCHLAUCH_CATEGORY_ID';
    public const CONFIG_UMLUFTVENTILATOR_CATEGORY = 'GROWSET2_UMLUFTVENTILATOR_CATEGORY_ID';
    public const CONFIG_CONTROLLER_CATEGORY = 'GROWSET2_CONTROLLER_CATEGORY_ID';
    public const CONFIG_BACKEND_URL = 'GROWSET2_BACKEND_URL';
    public const CONFIG_TOKEN = 'GROWSET2_BACKEND_TOKEN';

    public function __construct()
    {
        $this->name = 'growset2';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Growset2';
        $this->need_instance = 0;

        parent::__construct();

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
        Configuration::deleteByName(self::CONFIG_GROWBOX_CATEGORY);
        Configuration::deleteByName(self::CONFIG_GROWLED_CATEGORY);
        Configuration::deleteByName(self::CONFIG_ABLUFT_VENTILATOR_CATEGORY);
        Configuration::deleteByName(self::CONFIG_AKTIVKOHLEFILTER_CATEGORY);
        Configuration::deleteByName(self::CONFIG_ABLUFTSCHLAUCH_CATEGORY);
        Configuration::deleteByName(self::CONFIG_UMLUFTVENTILATOR_CATEGORY);
        Configuration::deleteByName(self::CONFIG_CONTROLLER_CATEGORY);
        Configuration::deleteByName(self::CONFIG_BACKEND_URL);
        Configuration::deleteByName(self::CONFIG_TOKEN);

        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submitGrowset2')) {
            $this->updateConfigValue(self::CONFIG_GROWBOX_CATEGORY);
            $this->updateConfigValue(self::CONFIG_GROWLED_CATEGORY);
            $this->updateConfigValue(self::CONFIG_ABLUFT_VENTILATOR_CATEGORY);
            $this->updateConfigValue(self::CONFIG_AKTIVKOHLEFILTER_CATEGORY);
            $this->updateConfigValue(self::CONFIG_ABLUFTSCHLAUCH_CATEGORY);
            $this->updateConfigValue(self::CONFIG_UMLUFTVENTILATOR_CATEGORY);
            $this->updateConfigValue(self::CONFIG_CONTROLLER_CATEGORY);
            $this->updateConfigValue(self::CONFIG_BACKEND_URL);
            $this->updateConfigValue(self::CONFIG_TOKEN);
            $output .= $this->displayConfirmation($this->l('Settings updated'));
        }

        return $output . $this->renderForm();
    }

    protected function renderForm()
    {
        $defaultLang = (int) Configuration::get('PS_LANG_DEFAULT');

        $categories = $this->getCategoryOptions($defaultLang);

        $forms = [];

        $forms[]['form'] = [
            'legend' => ['title' => $this->l('Growbox')],
            'input' => [[
                'type' => 'select',
                'label' => $this->l('Category'),
                'name' => self::CONFIG_GROWBOX_CATEGORY,
                'options' => [
                    'query' => $categories,
                    'id' => 'id_category',
                    'name' => 'name',
                ],
            ]],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ],
        ];

        $forms[]['form'] = [
            'legend' => ['title' => $this->l('Grow LED')],
            'input' => [[
                'type' => 'select',
                'label' => $this->l('Category'),
                'name' => self::CONFIG_GROWLED_CATEGORY,
                'options' => [
                    'query' => $categories,
                    'id' => 'id_category',
                    'name' => 'name',
                ],
            ]],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ],
        ];

        $forms[]['form'] = [
            'legend' => ['title' => $this->l('Abluft Ventilator')],
            'input' => [[
                'type' => 'select',
                'label' => $this->l('Category'),
                'name' => self::CONFIG_ABLUFT_VENTILATOR_CATEGORY,
                'options' => [
                    'query' => $categories,
                    'id' => 'id_category',
                    'name' => 'name',
                ],
            ]],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ],
        ];

        $forms[]['form'] = [
            'legend' => ['title' => $this->l('Aaktivkohlefilter')],
            'input' => [[
                'type' => 'select',
                'label' => $this->l('Category'),
                'name' => self::CONFIG_AKTIVKOHLEFILTER_CATEGORY,
                'options' => [
                    'query' => $categories,
                    'id' => 'id_category',
                    'name' => 'name',
                ],
            ]],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ],
        ];

        $forms[]['form'] = [
            'legend' => ['title' => $this->l('Abluftschlauch')],
            'input' => [[
                'type' => 'select',
                'label' => $this->l('Category'),
                'name' => self::CONFIG_ABLUFTSCHLAUCH_CATEGORY,
                'options' => [
                    'query' => $categories,
                    'id' => 'id_category',
                    'name' => 'name',
                ],
            ]],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ],
        ];

        $forms[]['form'] = [
            'legend' => ['title' => $this->l('Umluftventilator')],
            'input' => [[
                'type' => 'select',
                'label' => $this->l('Category'),
                'name' => self::CONFIG_UMLUFTVENTILATOR_CATEGORY,
                'options' => [
                    'query' => $categories,
                    'id' => 'id_category',
                    'name' => 'name',
                ],
            ]],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ],
        ];

        $forms[]['form'] = [
            'legend' => ['title' => $this->l('Controller')],
            'input' => [[
                'type' => 'select',
                'label' => $this->l('Category'),
                'name' => self::CONFIG_CONTROLLER_CATEGORY,
                'options' => [
                    'query' => $categories,
                    'id' => 'id_category',
                    'name' => 'name',
                ],
            ]],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right',
            ],
        ];

        $forms[]['form'] = [
            'legend' => ['title' => $this->l('Backend Settings')],
            'input' => [
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

        $helper->fields_value[self::CONFIG_GROWBOX_CATEGORY] = $this->getConfigValue(
            self::CONFIG_GROWBOX_CATEGORY,
            'GROWSET2_GROWBOX_CATEGORY_ID'
        );
        $helper->fields_value[self::CONFIG_GROWLED_CATEGORY] = $this->getConfigValue(
            self::CONFIG_GROWLED_CATEGORY,
            'GROWSET2_GROWLED_CATEGORY_ID'
        );
        $helper->fields_value[self::CONFIG_ABLUFT_VENTILATOR_CATEGORY] = $this->getConfigValue(
            self::CONFIG_ABLUFT_VENTILATOR_CATEGORY,
            'GROWSET2_ABLUFT_VENTILATOR_CATEGORY_ID'
        );
        $helper->fields_value[self::CONFIG_AKTIVKOHLEFILTER_CATEGORY] = $this->getConfigValue(
            self::CONFIG_AKTIVKOHLEFILTER_CATEGORY,
            'GROWSET2_AKTIVKOHLEFILTER_CATEGORY_ID'
        );
        $helper->fields_value[self::CONFIG_ABLUFTSCHLAUCH_CATEGORY] = $this->getConfigValue(
            self::CONFIG_ABLUFTSCHLAUCH_CATEGORY,
            'GROWSET2_ABLUFTSCHLAUCH_CATEGORY_ID'
        );
        $helper->fields_value[self::CONFIG_UMLUFTVENTILATOR_CATEGORY] = $this->getConfigValue(
            self::CONFIG_UMLUFTVENTILATOR_CATEGORY,
            'GROWSET2_UMLUFTVENTILATOR_CATEGORY_ID'
        );
        $helper->fields_value[self::CONFIG_CONTROLLER_CATEGORY] = $this->getConfigValue(
            self::CONFIG_CONTROLLER_CATEGORY,
            'GROWSET2_CONTROLLER_CATEGORY_ID'
        );
        $helper->fields_value[self::CONFIG_BACKEND_URL] = $this->getConfigValue(
            self::CONFIG_BACKEND_URL,
            'GROWSET2_BACKEND_URL'
        );
        $helper->fields_value[self::CONFIG_TOKEN] = $this->getConfigValue(
            self::CONFIG_TOKEN,
            'GROWSET2_BACKEND_TOKEN'
        );

        return $helper->generateForm($forms);
    }

    private function getConfigValue(string $key, string $envKey)
    {
        return Configuration::get($key)
            ?: getenv($envKey);
    }

    private function updateConfigValue(string $key): void
    {
        $value = Tools::getValue($key, null);
        if ($value !== null) {
            Configuration::updateValue($key, $value);
        }
    }

    protected function getCategoryOptions(int $idLang): array
    {
        $tree = Category::getNestedCategories(null, $idLang, true);
        $options = [];
        $this->flattenCategories($tree, $options);
        return $options;
    }

    private function flattenCategories(array $categories, array &$options, int $depth = 0): void
    {
        foreach ($categories as $category) {
            $prefix = '|';
            $prefix .= $depth === 0 ? '-' : str_repeat('---', $depth);
            $options[] = [
                'id_category' => $category['id_category'],
                'name' => $prefix . $category['name'],
            ];
            if (!empty($category['children'])) {
                $this->flattenCategories($category['children'], $options, $depth + 1);
            }
        }
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

