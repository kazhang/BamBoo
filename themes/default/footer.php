		</div>
		<div class="span3 sidebar">
			<?=$this->load->view('sidebar');?>
		</div>
	</div>
		<div class="footer">
		<hr/>
		<span class="pull-right"><a href="#" rel="nofollow" title="返回页面顶部">↑回到顶部</a></span>
		<div>&copy; 2012 ZAKIR | Powered by <span style="color:#06CA19">BamBoo Blog</span> 0.1.0 based on <a href="http://www.codeigniter.org" rel="nofollow">CodeIgniter</a> 2.1.2</div>
		<div style="color:white">Run in {elapsed_time} seconds, used {memory_usage} memory.</div>
	</div>
</div><!--end of container-->
<?php if(!defined('SAE_TMP_PATH')):?>
<script src="<?=base_url('application/views/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('application/third_party/ueditor/third-party/SyntaxHighlighter/shCore.js')?>" type="text/javascript"></script>
<?php else:?>
<script src="http://<?=$_SERVER['HTTP_HOST'].'/application/views/bootstrap/js/bootstrap.min.js'?>" type="text/javascript"></script>
<script src="http://<?=$_SERVER['HTTP_HOST'].'/application/third_party/ueditor/third-party/SyntaxHighlighter/shCore.js')?>" type="text/javascript"></script>
<?php endif;?>
<script type="text/javascript">
     SyntaxHighlighter.all()
 </script>
</body>
</html>
