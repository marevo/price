<?php 
if(isset($_POST['name'],$_POST['name_file'])){
    $name_file = htmlspecialchars($_POST['name_file']);
    if( copy ( "./uploadFilesOld/$name_file" , "./uploadFile/price.csv" )){
        echo("choice_is_made");
        // header('Location:.index.php');
        exit;
    }else echo"not_choice_file";
    exit;
}
if(isset($_FILES['upload_price']) && $_FILES['upload_price']['tmp_name']){
    $uploaded_file = __DIR__.'/uploadFilesOld/'.basename($_FILES['upload_price']['name']);
    if(move_uploaded_file($_FILES['upload_price']['tmp_name'],$uploaded_file)){
        echo("успешно загрузили ".$uploaded_file);
        unset($_FILES['upload_price']);
    }
    else echo("не удалось загрузить файл");
}
//выдача на клиент объектов с названиями файлов в папке ./uploadFilesOld
$uploaded_file = '/uploadFiles/price.csv';
if(is_dir(__DIR__."/uploadFilesOld")){
    // echo "есть такая пака ".__DIR__."/uploadFilesOld";
    $all_files = scandir(__DIR__."/uploadFilesOld");
    unset($all_files[0],$all_files[1]);
    $files_for_js = '';
    foreach ($all_files as $file){
        $files_for_js .= "{name:\"$file \" , date:\"$file date \"},";
    }
    $files_for_js ="[".$files_for_js."]";
    echo "<script type='text/javascript'>var files_price_from_server = $files_for_js</script>" ;
}else echo("нет такой папки ".__DIR__."/uploadFilesOld");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
    
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src = js/vue.js></script>

    <title>upload_price</title>
</head>
<body>
    <div class="container" id="main_upload_file">
        <div class="row">
          <header class="text-center"><h2> страница загрузки нового прайса </h2></header>
        </div>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group"> все прайсы
                    <li class="list-group-tem" 
                        v-for="price in files_price_from_server"
                        >  
                        <button class='btn btn-primary'

                        v-bind:data-price = "price.name"
                        v-on:click="send_ajax_this_price"
                        >выбрать</button>
                        name:{{price.name}} 
                    </li>
                </ul>       
            </div>
            <div class="col-md-6">
                <form action="upload_file.php" method="post" enctype="multipart/form-data">
                    <input type = "file" class="btn btn-info" name="upload_price">
                    <input type = "submit" class="btn btn-primary" value="загрузить новый прайс" >
                </form>
            </div> 
        </div>
    </div>
    <script type="text/javascript" src="js/upload_file.js"></script>
</body>
</html>


