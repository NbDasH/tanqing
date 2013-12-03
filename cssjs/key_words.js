$(document).ready(function(e) {
    $('.key_words a').click(function(){
		$('input[name="key_words"]').val($('input[name="key_words"]').val()+$(this).html()+',');
		return false;
	});
});