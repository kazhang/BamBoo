<?php $this->load->view('admin/header');?>
	<h3>插件</h3>
	<table class="table table-hover table-condensed">
		<colgroup width="20"></colgroup>
		<colgroup width="200"></colgroup>
		<colgroup></colgroup>
		<thead>
		<tr><th>&nbsp;</th><th>名称</th><th>描述</th></tr>
		</thead>
		<tbody>
<?php foreach($plugins as $plugin):?>
		<tr class="no-op">
			<td><input type="checkbox" name="choosed[]" value="<?=$plugin['name']?>"/></td>
			<td style="text-align:left"><?=$plugin['name']?><div class="op"><?=anchor('admin/plugins/activate/'.$plugin['directory'],'启用')?></div></td>
			<td style="text-align:left"><?=$plugin['description']?><br /><?=$plugin['version']?>版本|作者为<?=$plugin['author']?></td>
		</tr>
<?php endforeach;?>
	</tbody>
	</table>
<?php $this->load->view('admin/footer');?>
