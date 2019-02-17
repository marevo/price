<?php
//index.php при работе с Vue.js 
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
    <!-- <meta charset="UTF-8"> -->
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
    <header><h5>прайс</h5></header>
    <form role='form' class= 'form-inline'>
        <div class="row" id="columns">
            <!-- <div > -->
            <div class="col-lg-3 col-md-3 col-sm-3  col-xs-3 ">
                    <input type="text" class="form-control" id="search" placeholder="Поиск товара">
                    <input type="text" class="form-control" id="persent" placeholder="% скидка">
                    <input type="text" 
                                       v-model="search_name_product"
                                       v-on:change = "searching_products_on_name"
                                       v-bind:size="10"
                     class="form-control"  placeholder="srch_name">
                     <input type='number'min='0.2' max='1.3' step='0.1'
                                       v-model="search_weight_product"
                                       v-on:change = "searching_products_on_weight"
                                       v-bind:size="4"
                                       v-bind:class ="{lightingRed:isNumber}" 
                     class="form-control"  placeholder="srch_weight">
                     <input type='number' min='0' max='20'class='form-control' placeholder='%disc' name='discount'
                                        v-bind:size="4"
                                        v-model="disc_persent"
                                        >
                                        <div v-on:input="disc_persent = form.discount.value" > no_click</div>
             </div>
            <!--<div class="col-lg-9 col-md-9 col-sm-9  col-xs-9 checkbox_group">
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
            </div> -->
            <!-- </div> -->
        </div> 
    </form>
    <button class="btn btn-success" v-once v-on:click="create_all_products">товары в js-obj</button>
    <button class="btn btn-success" v-on:click="searching_products_on_name">найти товар </button>
    <div> all:{{products_length}} ~ {{size_all_obj}} find:products_search_lenght}} ~ {{"sizeObj_finding"}}</div>
    <div class="row">
        <div class="col-md-2">
        <input type="checkbox" name='brandSel' id='lk' value='lisovaKazka' class='checkbox'
                     v-model="selected_brands"
                    
                              ><label class='toggle-container' for='lk'>ЛК</label>
        <span>selected:{{selected_brands}}</span>
        </div>
        <div class="col-md-10">
            <template v-for="brand in brands">
               <input type='checkbox' class='checkbox' 
                      name="brand_sel"
                      v-bind:value="brand" 
                      v-bind:id="brand.id" 
                      v-model="selected_brands"
                      v-on:change = "searching_products_on_selected_brands()"
                      ><label  v-bind:for="brand.id" class="toggle-container">{{brand.name}} </label>
            </template>
            
        </div>
    </div>
    <div  class="row class='text-left'">
        <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- <div class="table-responsive"> -->
                    <table v-show="products_search_lenght" class="table">
                        <thead><tr><td>найдено:{{products_search_lenght}}
                        <button v-on:click="orderByName" class='btn btn-small btn-default'>
                                            <span v-if="sortNameDown" class='glyphicon glyphicon-sort-by-attributes'></span>
                                            <span v-else class='glyphicon glyphicon-sort-by-attributes-alt'></span>
                                             Sort name</button>
                        <button v-on:click="orderByWeight" class='btn btn-small btn-default'>
                                            <span v-if="sortWeightDown" class='glyphicon glyphicon-triangle-top'></span>
                                            <span v-else class='glyphicon glyphicon-triangle-bottom'></span>
                                             Sort weight</button>
                        <input type='text'
                                v-model="search_in_table_search" 
                                :size=4
                                v-on:change="show_in_table"
                        >                     
                                        </td>
                                    <td>расф.</td><td>ед. изм.</td><td>цена ед.</td><td>цена уп.</td><td>ост. ед.</td><td>ост. ящ</td></tr></thead>
                        <tbody>
                            <tr
                                v-for="prod in products_search"
                                v-show="show_tr(prod.name)"
                                >
                                <td>{{prod.name}}</td><td>{{prod.pack_weight}}</td><td>{{prod.pack_weight_name}}</td>
                                <td>{{prod.price_for_one | discount(disc_persent) }}</td>
                                <td>{{prod.price_for_unit | discount(disc_persent)}}</td>
                                <td>{{prod.stock_balance_in_unit}}</td>
                                <td>{{prod.stock_balance_in_packaging}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- </div> -->
                    <ul class="list-group">
                        <li class="list-group-tem"
                            v-for="prod in products_search">
                            {{prod.name}} brand-{{prod.id_brand}}  расфасовка:{{prod.pack_weight}} {{prod.pack_weight_name}} цена {{prod.price_for_one | discount(disc_persent) }}
                        </li>
                    </ul>   
                </div>
            </div> 
            <!-- создание таблицы при считывании из файла -->  
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <?php 
                        $nameFile = 'price_13_02_19.csv';
                        if(is_file("uploadFiles/$nameFile")){
                            $textFilePriseCsv = new Text_csv_file($nameFile);
                            if( $tableTovarAll = $textFilePriseCsv->createTableTovarFrom_csv_file('mytable')){
                                echo "$tableTovarAll";
                                echo "<script type = 'text/javascript' src='js/vue_table.js'></script>";
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
        </div>
    </div>
<!-- container end -->    
</div>
<script type="text/javascript" src="js/index.js"></script>
</body>
</html>
