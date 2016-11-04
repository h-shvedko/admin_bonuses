function saveFilter()
{  
    $('input[type="button"]').attr('disabled', 'disabled');
    $.ajax({
        url	: app.createAbsoluteUrl('admin/bonuses/Ajaxbonuses/saveFilter'),
        error	: function ()
        {
            $('input[type="button"]').removeAttr('disabled');
            alert('Ошибка запроса');
        },
        success	: function(data)
        {
            location.href = '/admin/bonuses/bonuses/index/guid/' + data.subsession;
        },
        data	:
        {   
            YII_CSRF_TOKEN      : app.csrfToken,
            alias               : 'admin_bonuses_binar',
            username            : $("input#filter_username").val(),
            last_name           : $("input#filter_last_name").val(),
            first_name          : $("input#filter_first_name").val(),
            second_name         : $("input#filter_second_name").val(), 
            email               : $("input#filter_email").val(),
            sponsor_username    : $("input#filter_sponsor_username").val(),            
            skype               : $("input#filter_skype").val()            ,
            rank               : $("select#filter_rank").val() ,
            created_at               : $("input#filter_created_at").val() ,
            created_atend               : $("input#filter_created_atend").val()
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
    setDatepicker();
})

function setDatepicker()
{
    $.datepicker.setDefaults($.extend($.datepicker.regional["ru"]));
    $(".datepicker").datepicker({
        changeMonth:       true,
        changeYear:        true,
        yearRange:         '-1:+10',
        showOn: 			'button',
        buttonImage:		$('#asseturl').val() + '/img/icons/calendar.png',
        buttonImageOnly:	true
    });
}