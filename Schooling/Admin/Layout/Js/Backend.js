$(function(){
	
	$('[placeholder]').focus(function(){
		$(this).attr("data-text",$(this).attr("placeholder");
		$(this).attr("plaaceholder",''));
	}
	
});
$(.confirm).click(function(){
	return confirm('Are you sure..?');
});