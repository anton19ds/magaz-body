<?php

namespace app\modules\admin\controllers;

use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
/**
 * Default controller for the `admin` module
 */
class ParentController extends Controller
{

  public $title;
  public $preTitle;
  public $actionType = null;

  public $lang = null;

}