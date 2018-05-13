<?php

namespace app\base\migrate;

use app\base\{
    Migrate,
    helper\HelperDir
};

class MigrateController extends \app\base\ControllerCli
{
    public function __construct()
    {
        parent::__construct();

        $this->_('MIGRATION TOOL');
    }

    public function indexAction()
    {
        $model = new Migrate();
        if (!$new = HelperDir::ls(MIGRATE_PATH)[HelperDir::TYPE_FILE])
            return $this->_('Empty migrations');

        ksort($new);
        if ($old = $model->getOld()) {
            foreach ($old as $item) {
                if (isset($new[$item->key . '.php']))
                    unset($new[$item->key . '.php']);
            }
        }

        if (empty($new))
            return $this->_('Already up do date');

        $this->_('Found ' . count($new) . ' migrations...')->n();

        $model->prepareTable();
        foreach ($new as $name => $path) {
            $name = str_replace('.php', '', $name);
            $this->_($name);
            $class = "\\app\\migrate\\$name";
            $class::up();
            $model->add($name);
            $this->_('Done')->n();
        }

        return $this->_('All migrations are processed successfully');
    }

    public function createAction()
    {
        if (!$name = $this->request()->command(0))
            return $this->_('ERROR: Empty migration name parameter');

        if (!$name = preg_replace('~[^0-9A-z_]+~iu', '', $name))
            return $this->_('ERROR: Wrong migration name parameter');

        if (!is_dir(MIGRATE_PATH))
            return $this->_('ERROR: Directory is not exist "' . MIGRATE_PATH . '"');

        $name = 'Migrate_' . time() . "_$name";

        $content = @file_get_contents(BASE_PATH . 'base/migrate/create.tpl');
        $content = str_replace('{name}', $name, $content);

        @file_put_contents(MIGRATE_PATH . $name . '.php', $content);

        return $this->_('Migration "' . $name . '" created');
    }
}