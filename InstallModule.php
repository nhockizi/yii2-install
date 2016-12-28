<?php
namespace nhockizi\install;

use Yii;
use yii\web\View;
use yii\base\Application;
use yii\base\BootstrapInterface;

use nhockizi\cms\models\Module;
use nhockizi\cms\models\Setting;
use nhockizi\cms\assets\LiveAsset;

class InstallModule extends \yii\base\Module implements BootstrapInterface
{
    const VERSION = 0.9;

    public $settings;
    public $activeModules;
    public $controllerLayout = '@cms/views/layouts/main';

    private $_installed;

    public function init()
    {
        parent::init();

        if (Yii::$app->cache === null) {
            throw new \yii\web\ServerErrorHttpException('Please configure Cache component.');
        }

        $this->activeModules = Module::findAllActive();

        $modules = [];
        foreach ($this->activeModules as $name => $module) {
            $modules[$name]['class'] = $module->class;
            if (is_array($module->settings)) {
                $modules[$name]['settings'] = $module->settings;
            }
        }
        $this->setModules($modules);
    }


    public function bootstrap($app)
    {
        Yii::setAlias('cms', '@vendor/nhockizi/yii2-install');
    }

    public function renderToolbar()
    {
        $view = Yii::$app->getView();
        echo $view->render('@cms/views/layouts/frontend-toolbar.php');
    }

    public function getInstalled()
    {
        if ($this->_installed === null) {
            try {
                $db = Yii::$app->db;
                $this->_installed = Yii::$app->db->createCommand("SHOW TABLES LIKE '".$db->tablePrefix."%'")->query()->count() > 0 ? true : false;
            } catch (\Exception $e) {
                $this->_installed = false;
            }
        }
        return $this->_installed;
    }
}
