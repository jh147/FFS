<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class ControllerBase
 * @package backend\controllers
 */
class ControllerBase extends Controller
{
    public $enableCsrfValidation = false;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }
}
