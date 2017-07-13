<?php

namespace xiaohei\captcha;

/**

 * Captcha 验证码类

 *

 */



class Captcha

{

    public static $seKey    = 'sid.captcha.ylans.cn';

    public static $charset  = '123456789';//随机因子排除0OiLl1

    public static $code;              //验证码

    public static $codelen  = 4;      //验证码长度

    public static $width    = 180;    //定义验证码图片宽度

    public static $height   = 70;     //定义验证码图片高度

    public static $img;               //定义图像资源句柄

    public static $font;              //定义字体

    public static $fontsize = 50;     //定义字体的大小

    public static $fontcolor;         //制定字体的颜色

    public static $useZh    = false;  //使用中文验证码

    public static $expire   = 600;   //验证码过期时间

    public static $useCurve  = false;  //是否画混淆曲线



    public function __construct()

    {

        $ttfPath = dirname(__FILE__) . '/Captcha/' . (self::$useZh ? 'zhttfs' : 'ttfs') . '/';

        $dir = dir($ttfPath);

        $ttfs = array();

        while (false !== ($file = $dir->read())) {

            if($file[0] != '.' && substr($file, -4) == '.ttf') {

                $ttfs[] = $ttfPath . $file;

            }

        }

        $dir->close();

        self::$font = $ttfs[array_rand($ttfs)];

    }



    /**

     * GetRandomCode生成6随机码

     *

     */

    private function GetRandomCode()

    {

        $_len = strlen(self::$charset) - 1;

        self::$code = "";

        for ($i = 0; $i < self::$codelen; $i++) {

            if(!self::$useZh) {

                self::$code .= self::$charset[mt_rand(0, $_len)];

            }else{

                self::$code .= chr(mt_rand(0xB0,0xF7)).chr(mt_rand(0xA1,0xFE));

            }

        }

    }



    /**

     * GetCanvasBg创建画布背景

     *

     * imagecreatetruecolo 创建图像资源

     * imagecolorallocate 创建资源背景色

     * imagefilledrectangle 把颜色填充到矩形图像资源中

     */

    private function GetCanvasBg()

    {

        self::$img = imagecreatetruecolor(self::$width, self::$height);//创建资源对象

        $color = imagecolorallocate(self::$img, mt_rand(255, 255), mt_rand(255, 255), mt_rand(255, 255));//创建画布背景颜色

        imagefilledrectangle(self::$img, 0, self::$height, self::$width, 0, $color);//把背景颜色填充到画布资源对象里面



    }



    /**

     * GetImgFont 填充文本

     * imagecolorallocate 创建文本

     */

    private function GetImgFont()

    {

        $_x = self::$width / self::$codelen -5;//算出每个字体的最大距离

        for ($i = 0; $i < self::$codelen; $i++) {

            if(self::$useZh) {

                self::$fontcolor = imagecolorallocate(self::$img, mt_rand(0, 50), mt_rand(0, 50), mt_rand(0, 50));//定义字体的颜色

                imagettftext(self::$img, self::$fontsize, mt_rand(-5, 5), $_x * $i + mt_rand(1, 1), self::$height / 1, self::$fontcolor, self::$font, iconv("GB2312","UTF-8",  self::$code[$i]));

            }else{

                self::$fontcolor = imagecolorallocate(self::$img, mt_rand(0, 50), mt_rand(0, 50), mt_rand(0, 50));//定义字体的颜色

                imagettftext(self::$img, self::$fontsize, mt_rand(-5, 5), $_x * $i + mt_rand(1, 1), self::$height / 1, self::$fontcolor, self::$font, iconv("GB2312","UTF-8",  self::$code[$i]));

            }

        }

        $gray = imagecolorallocate(self::$img, 0, 0, 0);

        imagerectangle(self::$img, 0, 0, self::$width-1, self::$height-1, $gray);

        // 保存验证码

        isset($_SESSION) || session_start();

        $_SESSION[self::$seKey]['code'] = self::$code; // 把校验码保存到session

        $_SESSION[self::$seKey]['time'] = time();  // 验证码创建时间

    }



    /**

     *

     * 增加雪花,线条干扰干扰

     * GetImageLine

     * imageline 画线

     */

    private function GetImageLine()

    {

        self::_writeCurve();

        //增加雪花

        for ($i = 0; $i < 10; $i++) {

            $color = imagecolorallocate(self::$img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));

            imagestring(self::$img, mt_rand(1, 5), mt_rand(0, self::$width), mt_rand(0, self::$height), "*", $color);

        }

    }



    protected static function _writeCurve() {

        $px = $py = 0;

        self::$fontcolor = imagecolorallocate(self::$img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));//定义字体的颜色

        // 曲线前部分

        $A = mt_rand(1, self::$height/2);                  // 振幅

        $b = mt_rand(-self::$height/4, self::$height/4);   // Y轴方向偏移量

        $f = mt_rand(-self::$height/4, self::$height/4);   // X轴方向偏移量

        $T = mt_rand(self::$height, self::$width*2);  // 周期

        $w = (2* M_PI)/$T;



        $px1 = 0;  // 曲线横坐标起始位置

        $px2 = mt_rand(self::$width/2, self::$width * 0.8);  // 曲线横坐标结束位置



        for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {

            if ($w!=0) {

                $py = $A * sin($w*$px + $f)+ $b + self::$height/2;  // y = Asin(ωx+φ) + b

                $i = (int) (self::$fontsize/5);

                while ($i > 0) {

                    imagesetpixel(self::$img, $px , $py + $i, self::$fontcolor);  // 这里(while)循环画像素点比imagettftext和imagestring用字体大小一次画出（不用这while循环）性能要好很多

                    $i--;

                }

            }

        }



        // 曲线后部分

        $A = mt_rand(1, self::$height/2);                  // 振幅

        $f = mt_rand(-self::$height/4, self::$height/4);   // X轴方向偏移量

        $T = mt_rand(self::$height, self::$width*2);  // 周期

        $w = (2* M_PI)/$T;

        $b = $py - $A * sin($w*$px + $f) - self::$height/2;

        $px1 = $px2;

        $px2 = self::$width;



        for ($px=$px1; $px<=$px2; $px=$px+ 0.9) {

            if ($w!=0) {

                $py = $A * sin($w*$px + $f)+ $b + self::$height/2;

                $i = (int) (self::$fontsize/5);

                while ($i > 0) {

                    imagesetpixel(self::$img, $px, $py + $i, self::$fontcolor);

                    $i--;

                }

            }

        }

    }



    /**

     * 输出图像

     */

    private function GetImage()

    {

        header("Content-type:image/png");

        imagepng(self::$img);

        imagedestroy(self::$img);

    }



    /**

     * 对外输出图像

     *

     * OutPutImage 对外输出图像

     */

    public function OutPutImage()

    {

        self::GetCanvasBg();//创建背景

        self::GetRandomCode();//获取随机码

        self::GetImageLine();//创建干扰元素

        self::GetImgFont();//创建文本内容

        self::GetImage();

    }



    /**

     * 验证验证码是否正确

     *

     * @param string $code 用户验证码

     * @return bool 用户验证码是否正确

     */

    public static function check($code) {

        isset($_SESSION) || session_start();

        // 验证码不能为空

        if(empty($code) || empty($_SESSION[self::$seKey])) {

            return false;

        }

        $secode = $_SESSION[self::$seKey];

        // session 过期

        if(time() - $secode['time'] > self::$expire) {

            return false;

        }

        if(strtoupper($code) == strtoupper($secode['code'])) {

            return true;

        }

        return false;

    }



    public function GetCode()

    {

        return strtolower(self::$code);

    }

}



?>