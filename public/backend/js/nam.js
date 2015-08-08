function block_error_input(item,mes,clear){
	item.parent().addClass('has-error');
	item.next().remove();
	item.after('<span class="help-block"><i class="icon-warning-sign"></i> '+mes+'</span>');
	item.focus();
	if(clear==false){
		item.val('');
	}
}
function block_ok_input(item){
	item.parent().removeClass('has-error');
	item.next().remove();
}

function form_action_ok(item,mes){
	var temp = '<div class="alert alert-success">';
		temp += '<i class="fa fa-check-circle fa-fw fa-lg"></i>';
		temp += '<strong>'+mes+'</strong>';
		temp += '</div>';
	item.html(temp);
}
