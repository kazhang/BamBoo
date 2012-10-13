<?php $this->load->view('admin/header');?>
	<h3>插件</h3>
	<table>
		<tr><th>&nbsp;</th><th>名称</th><th>描述</th></tr>
<?php foreach($plugins as $plugin):?>
		<tr>
			<td><input type="checkbox" name="choosed[]" value="<?=$plugin['name']?>"/></td>
			<td><?=$plugin['name']?><br /><?=anchor('admin/plugins/activate/'.$plugin['directory'],'启用')?></td>
			<td><?=$plugin['description']?></td>
		</tr>
<?php endforeach;?>
	</table>
<?php $this->load->view('admin/footer');?>
