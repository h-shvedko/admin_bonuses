function saveFilter()
{  
    $('input[type="button"]').attr('disabled', 'disabled');
	$page = $('#location').val();
    $.ajax({
        url	: app.createAbsoluteUrl('admin/bonuses/Ajaxbonuses/saveFilter'),
        error	: function ()
        {
            $('input[type="button"]').removeAttr('disabled');
            alert('ќшибка запроса');
        },
        success	: function(data)
        {
            location.href = $page + '/subsession/' + data.subsession;
        },
        data	:
        {   
            YII_CSRF_TOKEN      : app.csrfToken,
            alias               : 'admin_bonuses_bonuses',
            username            : $("input#filter_username").val(),
			phone            : $("input#filter_phone").val(),
			bonuses_name        : $("#filter_bonuses_name").val(),
			amount            : $("input#filter_amount").val(),
			points            : $("input#filter_points").val(),
        },
        async		: false,
        cache		: false,
        type        : "POST"
    });
}

$(function(){
    $('input[name="btn_filter"]').bind('click', function(){
        saveFilter();
    });
	
	$('#confirmpaid').submit(function(){
		
		if (confirm(T('Подтвердить операцию? Отмена будет невозможна')))
		{
			return true;
		}
		else
		{
			return false;
		}
	});

});

