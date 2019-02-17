$(document).ready(function(){
    //переменная содержит массив брендов для отображения получается при любом переключении чекбоксов
    var arrayBrandToSee,
        text_in_input
    ;
    //функция считывания в text_in_input_toLowerCase что в инпуте
    function what_text_in_input(){
        text_in_input = $('#search').val();
        return text_in_input;
    }
     //функция выбран ли бренд
     function isBrandChecked() {
        find_checked_checkboxes();
        return arrayBrandToSee != undefined && arrayBrandToSee.length;
    }
      //функция добавки в массив id бренда для последующего отображения только товара с выбраным брендом
   function find_checked_checkboxes(){
    arrayBrandToSee = unique( $('input:checkbox:checked') );
    // console.clear();
   // arrayBrandToSee.forEach(function(item,i,arr){
        // console.log(item);
        //console.log(arrayBrandToSee);
    //});
    // $(document).trigger('function_find_checked_checkboxes_complete')
   }
   //функция удаления одинаковых членов из массива
   function unique(arr) {
        var obj = {};
        for (var i = 0; i < arr.length; i++) {
        var str = $(arr[i]).prop('id');
        obj[str] = true; // запомнить строку в виде свойства объекта
        }
        return Object.keys(obj); // или собрать ключи перебором для IE8-
    }
    //функция показа по бренду и искомому слову в input#search
    function  show_tr_with_brand_and_textInput(text_in_input_toLowerCase){
        $.each($('#mytable tbody tr'),function(){
            var id_brand = $(this).data('id_brand');
            if(-1 == arrayBrandToSee.indexOf(id_brand)){
                $(this).hide();
            }else{
                var td2_in_this_tr = $(this).find('td:nth-child(2)');
                if(-1 == $(td2_in_this_tr).text().toLowerCase().indexOf(text_in_input_toLowerCase)){
                    $(this).hide();
                }else{
                    $(this).show();
                }
            }
        });
    }
    //функция показа только по бренду
    function show_tr_with_brand(){
        $.each($("#mytable tbody tr"), function() {
            var id_brand = $(this).data('id_brand');
            if(-1 == arrayBrandToSee.indexOf(id_brand)){
                $(this).hide();
            }else{
                $(this).show();
            }
       });



     /*
        $.each($("#mytable tbody tr td:nth-child(2)"), function() {
            if( -1 ==  $(this).text().toLowerCase().indexOf( text_in_input_toLowerCase) ){
                $(this).parent().hide();
            }else{
                $(this).parent().show();  
            }
        });

        $.each($('#mytable tbody tr'),function(){
            
            
            if(-1 == arrayBrandToSee.indexOf(id_brand)){
            $(this).hide();
        }else{
        */
    }
    // функция показа строк если во второй ячейке есть вхождение переданного параметра 
    function show_tr_if_textInput_exist_in_td_2(text_in_input_toLowerCase){
        $.each($("#mytable tbody tr td:nth-child(2)"), function() {
            if( -1 ==  $(this).text().toLowerCase().indexOf( text_in_input_toLowerCase) ){
                $(this).parent().hide();
            }else{
                $(this).parent().show();  
            }
        });
    }
    
    $("#search").on('keyup',all_search);
    $(".checkbox_group").on('change',all_search);
 
    //функция поиска по любому из событий (изменение в поле input, выбор бренда)
    function all_search(){
        var text_in_input_toLowerCase = what_text_in_input().toLowerCase()
        ;
        if(isBrandChecked()){
            if(what_text_in_input()){
                show_tr_with_brand_and_textInput(text_in_input_toLowerCase);
            }else{
                show_tr_with_brand();
            }
        }else{
            if(what_text_in_input()){
                show_tr_if_textInput_exist_in_td_2(text_in_input_toLowerCase);
            }
        }

    }
  
    //функция изменения цен в процентах
    //при вводе в #persent числа будет для всех товаров произведен пересчет цен в колонке 5 с учетом скидки 
    $('#persent').keyup(function(){
        //alert($(this).val());
        var _persent = (parseFloat($(this).val())).toFixed(2);
        if(_persent>0){
            $.each($("#mytable tbody tr td:nth-child(5)"), function(index,text) {
                // $(this).append(document.createTextNode(" - " + _persent + "%").addClass('delete_persent')); 
                var _base_price = parseFloat( $(this).data('base_price') );

                var _textToFloat = parseFloat($(this).text());
                var _textToFloat_2 = +($(this).text());

                var new_value = (_base_price * ( (100 - _persent) / 100) ).toFixed(2);
                return $(this).text(_base_price +"/"+new_value).addClass('discount_price');
            });
        }
        else{
            $.each($("#mytable tbody tr td:nth-child(5)"), function(index,text) {
                // $(this).append(document.createTextNode(" - " + _persent + "%").addClass('delete_persent')); 
                var _base_price = $(this).data('base_price') ;
                return $(this).text(_base_price).removeClass('discount_price');
            });
        }
    });
   
});


