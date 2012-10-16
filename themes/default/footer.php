		</div>
		<div class="span3 sidebar">
			<?=$this->load->view('sidebar');?>
		</div>
	</div>
	<div class="footer">
	<hr/>
	<p>Powered by BamBoo 0.1.0 based on CodeIgniter 2.1.2</p>
	<p>&copy; 2012 ZAKIR</p>
	<?php echo $this->benchmark->elapsed_time();?>seconds
	</div>
	<script src="<?=base_url('application/views/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
</div><!--end of container-->
</body>
</html>
