let upload_file = new Vue({
  el:'#main_upload_file',
  data:{
      //файлы прайсов за разные даты
    files_price : [
        {name:"price", date:"20.02.18"},
        {name:"price", date:"16.02.18"},
        {name:"price", date:"10.02.18"},
        {name:"price", date:"04.02.18"}
    ],//загруженные файлы прайсов

  }
});