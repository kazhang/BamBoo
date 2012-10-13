$(document).ready(function(){
	$('.no-op').mouseenter(function(){
		$('.op',this).css('visibility','visible');
	});
	$('.no-op').mouseleave(function(){
		$('.op',this).css('visibility','hidden');
	});
	$('.del').click(function(){
		return confirm('您将永远删除所选项目。\r\n点击“取消”停止，点击“确定”删除。');
	});
});
