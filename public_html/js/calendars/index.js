$(document).ready(function () {

	$('.delete-action').click(function() {
		$('.form-delete').submit();
	});

	$("input[type='checkbox']").change(function() {
		var count = $("input[type='checkbox']:checked").length;
		if(count > 0) {
			$('.main-navbar').addClass('hide');
			$('.second-navbar').removeClass('hide');
			if(count > 1) {
				$('.count').html(count + ' itens selecionados.');
			} else {
				$('.count').html('1 item selecionado.');
			}
			
		} else {
			$('.second-navbar').addClass('hide');
			$('.main-navbar').removeClass('hide');
		}
	});

	$("input[type='checkbox']").change(function() {
		if($(this).prop('checked')) {
			$(this).next('a').children('i').removeClass('hide');
			$(this).next('input').removeClass('hide');
			$(this).next('label').removeClass('hide');
		} else {
			$(this).next('a').children('i').addClass('hide');
			$(this).next('input').addClass('hide');
			$(this).next('label').addClass('hide');
		}
	});

	$('.collapsible-header').hover(function() {
		$(this).children('a').children('i').removeClass('hide');
		$(this).children('input').removeClass('hide');
		$(this).children('label').removeClass('hide');
	}, function() {
		if(!$(this).children('input').prop('checked')) {
			$(this).children('a').children('i').addClass('hide');
			$(this).children('input').addClass('hide');
			$(this).children('label').addClass('hide');
		}
	});

	$('.collapsible').collapsible();

    $("input[type='checkbox']").trigger('change');
});