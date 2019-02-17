<?php //index.php при работе с событиями через jquery
require_once "App/Model/Product.php";
require_once "App/Model/Text_csv_file.php";
use App\Model\Product;
use App\Model\Text_csv_file;

// use App\Model\Text_csv_file;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/dataTable.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src = js/vue.js></script>
    <script type="text/javascript" src="js/sizeof.compressed.js"></script>
    <!-- <script type="text/javascript" src="js/jsSortSearchTable.js"></script>  -->
    <!-- <script type="text/javascript" src="js/jsForTable2.js"></script> -->
</head>
<body>
<div id="container_main" class="container-fluid" >
    <header></header>
    <form role='form' class= 'form-inline'>
        <div class="row" id="columns">
            <div class="col-lg-3 col-md-3 col-sm-3  col-xs-3 ">
                <input type="text" class="form-control" id="search" placeholder="Поиск товара">
                <input type="text" class="form-control" id="persent" placeholder="% скидка">
            </div>
            
            <!-- <div > -->
            <div class="col-lg-9 col-md-9 col-sm-9  col-xs-9 checkbox_group">
                    <input type="checkbox" name='brand' id='lisovaKazka' value='lisovaKazka' class='checkbox'><label class="toggle-container" for="lisovaKazka">лк</label>
                    <input type="checkbox" name='brand' id='zhorik_obzhorik' value='zhorik_obzhorik' class='checkbox'><label class="toggle-container" for="zhorik_obzhorik">жорик</label>
                    <input type="checkbox" name='brand' id='sweet_company' value='sweet_company' class='checkbox'><label class="toggle-container" for="sweet_company">свит компани</label>
                    <input type="checkbox" name='brand' id='shokoladno' value='shokoladno' class='checkbox'><label class="toggle-container" for="shokoladno">шоколадно</label>
                    <input type="checkbox" name='brand' id='stimul' value='stimul' class='checkbox'><label class="toggle-container" for="stimul">стимул</label>
                    <input type="checkbox" name='brand' id='vavryk' value='vavryk' class='checkbox'><label class="toggle-container" for="vavryk">ваврик</label>
                    <input type="checkbox" name='brand' id='sergis' value='sergis' class='checkbox'><label class="toggle-container" for="sergis">сергис</label>
                    <input type="checkbox" name='brand' id='luskunchik' value='luskunchik' class='checkbox'><label class="toggle-container" for="luskunchik">лускунчик</label>
                    <input type="checkbox" name='brand' id='faraon' value='faraon' class='checkbox'><label class="toggle-container" for="faraon">фараон</label>
                    <input type="checkbox" name='brand' id='zahid' value='zahid' class='checkbox'><label class="toggle-container" for="zahid">захид</label>
                    <input type="checkbox" name='brand' id='pripraves' value='pripraves' class='checkbox'><label class="toggle-container" for="pripraves">приправы</label>
            </div>
            <!-- </div> -->
        </div> 
    </form>
    <div  class="row class='text-left'">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <?php 
                $nameFile = 'price_13_02_19.csv';
                if(is_file("uploadFiles/$nameFile")){
                    $textFilePriseCsv = new Text_csv_file($nameFile);
                    if( $tableTovarAll = $textFilePriseCsv->createTableTovarFrom_csv_file('mytable')){
                        echo "$tableTovarAll";
                        // echo "<script type = 'text/javascript' src='js/vue_table.js'></script>";
                    }
                    else
                        echo " ошибка при формировании таблицы товаров";
                }else{
                    echo"такого $nameFile не существует";
                }
                
                ?>
            </div>
        </div>
    </div>
<!-- container end -->    
</div>
<!-- подключение файла js для обработки событий через jquery -->
<script type="text/javascript" src="js/index.js"></script>
</body>
</html>
