var comment={
	moveRespond:function(dstID,type){
		if(type == 1)
		{
			$('#comment-'+dstID).append($('#respond'));
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
};		
