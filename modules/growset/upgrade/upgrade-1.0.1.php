<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_0_1($module)
{
    return $module->registerHook('displayHeader') &&
        $module->registerHook('displayHome');
}

