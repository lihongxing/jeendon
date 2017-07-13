<?
use yii\helpers\Url;
$this->title = yii::$app->params['siteinfo']['sitename'] . '-欢迎';
$this->params['breadcrumbs'][] = '欢迎';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<script src="/api/Highcharts/code/highcharts.js"></script>
<!-- Main content -->
<section class="content">
    <section class="content">      <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">          <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner"><h3><?=$ordercount?></h3>
                        <p>发布订单数量</p></div>
                    <div class="icon"><i class="ion ion-bag"></i></div>
                    <a href="#" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a></div>
            </div>        <!-- ./col -->
            <div class="col-lg-3 col-xs-6">          <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner"><h3><?= $engineercount ?></h3>
                        <p>注册工程师数量</p></div>
                    <div class="icon"><i class="ion ion-person-add"></i></div>
                    <a href="#" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a></div>
            </div>        <!-- ./col -->
            <div class="col-lg-3 col-xs-6">          <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner"><h3><?= $employercount ?></h3>
                        <p>注册雇主数量</p></div>
                    <div class="icon"><i class="ion ion-person-add"></i></div>
                    <a href="#" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a></div>
            </div>        <!-- ./col -->
            <div class="col-lg-3 col-xs-6">          <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner"><h3><?=\app\models\Visit::visitNum()?></h3>
                        <p>访问量</p></div>
                    <div class="icon"><i class="ion ion-pie-graph"></i></div>
                    <a href="#" class="small-box-footer">更多 <i class="fa fa-arrow-circle-right"></i></a></div>
            </div>        <!-- ./col -->
        </div>
    </section>
	<div class="row">
        <!-- Left col -->
        <section class="col-lg-7">
          <!-- TO DO List -->
			<div class="box box-primary" id="container">
				
            </div>
			<script type="text/javascript">
				$.ajax({
					type: "POST",
					url: '<?=Url::toRoute("/admin/site/get-visits-count")?>',
					data: {type: 1, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
					datatype: "json",
					success: function (data) {
						Highcharts.chart('container', {
							chart: {
								type: 'line'
							},
							title: {
								text: '每日网站访问量一览表'
							},
							subtitle: {
								text: '每日网站访问量'
							},
							xAxis: {
								categories: data.visitDays
							},
							yAxis: {
								title: {
									text: '访问量'
								}
							},
							plotOptions: {
								line: {
									dataLabels: {
										enabled: true
									},
									enableMouseTracking: false
								}
							},
							series: [{
								name: '日期',
								data: data.visitcounts
							}]
						});
					}
				});

			</script>
          <!-- /.box -->
        </section>
        <!-- /.Left col -->
	</div>
	<!-- /.row (main row) -->
</section>