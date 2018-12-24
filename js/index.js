$(document).ready(function(){
    //функция показа строк только с набранными словами в поле input#search
    $("#search").keyup(function(){
        var _this = this;
        // console.log(_this);
        // var text_pr = $(_this).val();
        // console.log(text_pr);
        // var re = new RegExp(text_pr,"g");
        
        $.each($("#mytable tbody tr td:nth-child(2)"), function() {
            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1) {
                $(this).parent().hide();
            } else {
                $(this).parent().show();  
            // $(this).text().wrap("<span class='text_red'></span>");
                //  var re = new RegExp(txt,"g");
                // text_pr = text_pr.replace(re, '<span class="text_red">'+ txt +'</span>');
            }              
        });
    });
    //функция изменения цен в процентах
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


// $(document).ready(function() {
//     $("#search").keyup(function(){
//         var keyWord = $(this).val(); 
//         console.log(keyWord);
//         // var keyWord = $("#lblKeyword").text(); 
//         var replaceD = "<span class='highlight'>" + keyWord + "</span>";
//         $.each($("#mytable tbody tr").each(function() {
//         // $(".system, .filename, .content").each(function() {
//            var text = $(this).text();
//            text = text.replace(keyWord, replaceD);
//            $(this).html(text);
//         }));
//      });
    
//  });