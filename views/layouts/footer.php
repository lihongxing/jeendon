<!--底部开始-->
<style>
    #Frda .Shit1 .code {
        float: left;
        height: 120px;
        margin: 35px 30px 0 0;
        width: 130px;
    }
    #Frda .Shit1 .ontact {
        float: left;
        height: 140px;
        margin: 20px 0 0;
        width: 200px;
    }
    #Frda .Shit1 ul {
        margin: 20px 18px 0 0;
    }
	#htning {
		background: #ffffff none repeat scroll 0 0;
		height: auto;
		padding-bottom: 28px;
		width: 100%;
	}
	#htning .Jkuia_qEa {
		height: auto;
		margin: 0 auto;
		width: 1200px;
		padding-top:10px
	}
	#htning .Jkuia_qEa .Yyha_img {
		height: 131px;
		width: 1200px;
	}
	#htning .dship {
		background: #ffffff none repeat scroll 0 0;
		height: auto;
	}
	#htning .dship span {
		color: #666;
		float: left;
		font-size: 12px;
		height: 100%;
		margin-right: 10px;
	}
	#htning .dship .Lougr {
		float: left;
		font-size: 12px;
		padding: 2px 0 5px;
		width: 1115px;
	}
	#htning .dship a {
		border-right: 1px solid #a7a3a3;
		color: #666;
		float: left;
		height: 12px;
		line-height: 14px;
		margin-bottom: 10px;
		margin-left: 15px;
		padding-right: 15px;
	}
	#htning .dship a:hover {
		color: #068ce3;
	}
	#htning ul.Vxvhm {
		height: auto;
		width: auto;
	}
	#htning ul.Vxvhm li {
		float: left;
		height: 31px;
		margin-right: 23px;
		text-align: center;
		width: 88px;
	}
	#htning ul.Vxvhm li.Tvcnmm {
		float: left;
		margin-right: 0;
	}
</style>
<div id="Frda">
	<?=\app\widgets\PlatWidget::widget()?>
    <div class="Shit1" id="cheng">
        <?=\app\widgets\FooterWidget::widget()?>
        <div style="float: right;padding-right: 0px">
            <div class="code">
                <img src="/frontend/images/code.jpg"/>
            </div>
            <div class="ontact">
                <dl>
                    <dt><?=yii::$app->params['siteinfo']['phone']?></dt>
                    <dd style="margin-top: 12px;">8：00~17：00(周一至周六)</dd>
                </dl>
                <a href="">在线客服</a>
            </div>
        </div>
    </div>
    <div class="Bgye" id="cheng">
        <p>
            ©2016 - 2025 拣豆网-您身边的模具设计专家！ 版权所有 沪ICP备16036769号 运营中心地址：<?=yii::$app->params['siteinfo']['address']?>
        </p>
       <div class="Cted">
            <a href="http://218.242.124.22:8081/businessCheck/verifKey.do?serial=31000091310117a39a271a361a36a32a466a44001002-SAIC_SHOW_310000-20170628172148705309&signData=MEQCIEiwaqVWFQso5lgJ0hrHWWrasWXQWAGKfvHdXWtFa57RAiA2j+gz+Kfnm720A+XLIQB77jmz77zDI6ZIOy5LdKEsoQ==">
                <img src="/frontend/images/copy_01.jpg" style="height: 50px"/>
            </a>
        </div>
    </div>
</div>