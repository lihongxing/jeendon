<div id="htning">
	<div class="Jkuia_qEa">
		<div class="dship">
			<span>友情链接：</span>
			<div class="Lougr">
			<?php if(!empty($items)){?>
				<?php foreach($items as $key => $item){?>
					<a href="<?=$item['platform_href']?>" target="_blank"><?=$item['platform_name']?></a>
				<?php }?>
			<?php }?>
		</div>
			<div class="clear" style="height: 0;"></div>
		</div>
	</div>
</div>
