$(function () {
    $('.city-name a').on('click', function (e) {
        e.preventDefault();
        $(this).siblings('form').slideToggle(250);
    });


    $('.edit-city').on('submit', function () {

        var id = $(this).parent().data('id');
        var name = $(this).children('input').val();
        var text = $(this).siblings('span');
        var form = $(this);

        $.ajax({
            url: '/application/edit',
            data: {
                id: id,
                name: name
            },
            type: 'POST',
            success: function(data){ // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
                if(data == '1'){
                    text.text(name);
                    form.slideToggle(250);
                    form.trigger('reset');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) { // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
                alert(xhr.status); // пoкaжeм oтвeт сeрвeрa
                alert(thrownError); // и тeкст oшибки
            }
        });

        return false;
    });

    $('.filter-row form').on('submit', function () {

        var form = $(this);
        var data = form.serialize();

        console.log(form);

        $.ajax({
            url: '/application/filter',
            data: data,
            type: 'POST',
            success: function(data){ // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
                if(data){
                    $('.table tbody').html(data);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) { // в случae нeудaчнoгo зaвeршeния зaпрoсa к сeрвeру
                alert(xhr.status); // пoкaжeм oтвeт сeрвeрa
                alert(thrownError); // и тeкст oшибки
            }
        });

        return false;
    });

    $('#PopulationMin').keydown(function(e){ //отлавливаем нажатие клавиш
        if (e.keyCode == 13) { //если нажали Enter, то true
            $(this).parents('form').submit();
        }
    });

    $('#PopulationMax').keydown(function(e){ //отлавливаем нажатие клавиш
        if (e.keyCode == 13) { //если нажали Enter, то true
            $(this).parents('form').submit();
        }
    });
});