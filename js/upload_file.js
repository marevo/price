let upload_file = new Vue({
  el:'#main_upload_file',
  data:{
      //файлы прайсов за разные даты для проверки отображения 
      //не используются когда есть js объект files_price_from_server
    files_price : [
        {name:"price", date:"20.02.18"},
        {name:"price", date:"16.02.18"},
        {name:"price", date:"10.02.18"},
        {name:"price", date:"04.02.18"},
    ],//загруженные файлы прайсов
    //файлы данных, что приходят с сервера через js переменную files_price_from_server
    files_price_from_server : files_price_from_server,
  },
  methods:{
    send_ajax_this_price : function(e){
        var elem = e.target;
        var data_elem = $(elem).data('price');
        $.ajax({
            type:"POST",
            url: "upload_file.php",
            // dataType: "multipart/form-data",
            data: {'name':'','name_file':data_elem},
            success: function(response, status, xhr) {
                if(status =="success" && xhr.responseText == "choice_is_made"){
                    $('.this_li').removeClass('this_li');
                    $('.btn').text('выбрать')
                    $(elem).addClass('this_li').text('выбрано').parent().addClass('this_li');
                }
                setTimeout(
                    function(){window.location.href = "index.php";}
                    ,2000);
            },
            error: function(response, status, xhr){
                console.log('Возникла ошибка: ' + xhr.responseCode);
            }
        });
        // e.preventDefault();
        // return false;
    }
  }
    

});