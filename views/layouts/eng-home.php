<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="<?=yii::$app->params['siteinfo']['siteurl'].'/'.yii::$app->params['siteinfo']['icon']?>">
    <title><?=$this->title?></title>
    <?php $this->head() ?>
    <script src="/frontend/js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/frontend/js/scroll.1.3.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $(function() {
            var $this = $(".scrollNews");
            var scrollTimer;
            $this.hover(function() {
                clearInterval(scrollTimer);
            }, function() {
                scrollTimer = setInterval(function() {
                    scrollNews($this);
                }, 1000);
            }).trigger("mouseleave");
        });

        function scrollNews(obj) {
            var $self = obj.find("ul:first");
            var lineHeight = $self.find("li:first").width(); //获取宽度，向上滚动则需要获取高度.height()
            $self.animate({
                "marginLeft": -lineHeight + "px"
            }, 600, function() { //向左滚动，向上滚动则需要改为marginTop,其他方向类似，下同
                $self.css({
                    marginLeft: 0
                }).find("li:first").appendTo($self); //appendTo能直接移动元素
            })
        }
    </script>
    <link rel="stylesheet" type="text/css" href="/frontend/css/index.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/css/t_head.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/css/signin.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/css/handsome.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/css/mabody.css"/>
</head>
<body>
<?php $this->beginBody() ?>
<!--头部开始-->
<?= $this->render('header.php')?>
<!--头部结束-->

<!--内容开始-->
<?=$content?>
<!--内容结束-->

<!--底部开始-->
<?= $this->render('footer.php')?>
<!--底部结束-->

<!--侧边栏开始-->
<?= $this->render('sidebar.php')?>
<!--侧边栏结束-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script src="/frontend/js/index.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/mold_j.js" type="text/javascript" charset="utf-8"></script>
