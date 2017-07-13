<?php
namespace dmstr\web;

use yii\base\Exception;
use yii\web\AssetBundle as BaseAdminLteAsset;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class AdminLteAsset extends BaseAdminLteAsset
{
    public $sourcePath = '@vendor/AdminLTE/adminlte/dist';
    public $css = [
        //daterange picker
//        'plugins/daterangepicker/daterangepicker.css',
//        //bootstrap datepicker
//        'plugins/datepicker/datepicker3.css',
//        //iCheck for checkboxes and radio inputs
//        'plugins/iCheck/all.css',
//        //Bootstrap Color Picker -->
//        'plugins/colorpicker/bootstrap-colorpicker.min.css',
//        //Bootstrap time Picker
//        'plugins/timepicker/bootstrap-timepicker.min.css',
//        //Select2
//        'plugins/select2/select2.min.css',
          //'css/AdminLTE.min.css'
    ];
    public $js = [
        //Select2
//        'plugins/select2/select2.full.min.js',
//        //InputMask
//        'plugins/input-mask/jquery.inputmask.js',
//        'plugins/input-mask/jquery.inputmask.date.extensions.js',
//        'plugins/input-mask/jquery.inputmask.extensions.js',
//        //date-range-picker
//        'plugins/daterangepicker/moment.min.js',
//        'plugins/daterangepicker/daterangepicker.js',
//        //bootstrap datepicker
//        'plugins/datepicker/bootstrap-datepicker.js',
//        //bootstrap color picker
//        'plugins/colorpicker/bootstrap-colorpicker.min.js',
//        //bootstrap time picker
//        'plugins/timepicker/bootstrap-timepicker.min.js',
//        //SlimScroll 1.3.0
//        'plugins/slimScroll/jquery.slimscroll.min.js',
//        //iCheck 1.0.1
//        'plugins/iCheck/icheck.min.js',
//        //FastClick
//        'plugins/fastclick/fastclick.js',
        'js/app.js'
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
    ];

    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = '_all-skins';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Append skin color file if specified
        if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }

            $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
        }
        parent::init();
    }
}
