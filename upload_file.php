<?php 
use App\Model\Text_csv_file;

require_once "App/Model/Text_csv_file.php";
require_once "App/Model/Text_csv_file.php";

//выбор файла из списка на сервере для отображения прайса
if(isset($_POST['name'],$_POST['name_file'])){
    $name_file = htmlspecialchars($_POST['name_file']);
    if( copy ( "./uploadFilesOld/$name_file" , "./uploadFile/price.csv" )){
        echo("choice_is_made");
        // header('Location:.index.php');
        exit;
    }else echo"not_choice_file";
    exit;
}

/**
 * upload file on server into path = upladFilesOdld/name
 */
if(isset($_FILES['upload_price']) && $_FILES['upload_price']['tmp_name']){
    //место куда будет перемещен файл из загруженного на сервер
    $uploaded_file = $_SERVER['DOCUMENT_ROOT'].'/uploadFilesOld/'.basename($_FILES['upload_price']['name']);
    //получим дату прайса из файла
    $date_price =   Text_csv_file::get_date_cvs_price($uploaded_file);
    $new_path_uploading_file = $_SERVER['DOCUMENT_ROOT'].'/uploadFilesOld/'."price_$date_price.csv";
    if(move_uploaded_file($_FILES['upload_price']['tmp_name'],$new_path_uploading_file)){
        echo("успешно загрузили  $uploaded_file <br> по пути $new_path_uploading_file <br>");
        unset($_FILES['upload_price']);
    }
    else echo("не удалось загрузить файл");
}

if(is_dir($_SERVER['DOCUMENT_ROOT']."/uploadFilesOld")){
    // echo "есть такая пака ".$_SERVER['DOCUMENT_ROOT']."/uploadFilesOld";
    $all_files = scandir($_SERVER['DOCUMENT_ROOT']."/uploadFilesOld");
    unset($all_files[0],$all_files[1]);
    $files_for_js = '';
    foreach ($all_files as $file){
        $files_for_js .= "{name:\"$file \" , date:\"$file date \"},";
    }
    $files_for_js ="[".$files_for_js."]";
    echo "<script type='text/javascript'>var files_price_from_server = $files_for_js</script>" ;
}else echo("нет такой папки ".$_SERVER['DOCUMENT_ROOT']."/uploadFilesOld");

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


