<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('header');
?>
		<div class="post">
			<div class="content">
				<?php echo $post['content'];?>
			</div>
		</div>
		<?php $this->load->view('comment');?>
<?php $this->load->view('footer');?>
