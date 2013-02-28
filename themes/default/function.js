var comment={
	moveRespond:function(dstID,type){
		if(type == 1)
		{
			$('#comment-'+dstID+' > .comment-wrap').append($('#respond'));
			$('#replyTo').val(dstID);
			$('.reply-op').show();
		}
		else
		{
			$('#'+dstID).after($('#respond'));
			$('#replyTo').val('0');
			$('.reply-op').hide();
		}
		return false;
	},
	sMe:function(){
		$("#sMe").val(1);
	}
};		

$(document).ready(function(){
	$('#keyword').focus(function(){
		$(this).removeClass('span1');
		$(this).addClass('span2');
	});
	$('#keyword').blur(function(){
		$(this).removeClass('span2');
		$(this).addClass('span1');
	});
});
