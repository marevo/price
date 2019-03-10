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
    <title>price_vue.js</title>
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/main.css">
    
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src = js/vue.js></script>
    <script type="text/javascript" src="js/sizeof.compressed.js"></script>
    
    <!-- production-версия, оптимизированная для размера и скорости-->
    <!-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->
</head>
<body>
<div id="container_main" class="container-fluid" >
        <div class="row" >
            <!-- <div > -->
            <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
            <div class="col-lg-4 col-md-5  col-sm-6 col-xs-8">
                <div class="input-group" >
                    <span class="input-group-btn">
                       <a href='./upload_file.php' target='_blank' class="btn btn-success" type="button">выбрать прайс</a>
                    </span>
                    <input type="text" v-model="date_price_value" class='form-control text-center'
                        :style="style_input_disabled"  placeholder="date_price" disabled
                    >
                    <!-- <span class class="input-group text-center">{{date_price_value}}</span> -->
                    <span class="input-group-btn"
                          v-show="!products_length"
                    >
                       <button class="btn btn-success" v-on:click.stop.prevent.once="create_all_products">товары в js-obj</button>
                    </span>
                    <span type="text" v-show="products_length"
                             class='input-group-addon text-center'
                             :style="{'background-color':'#c4c8ca73'}"  
                    >товаров:{{products_length}}</span>
                </div>
            </div> <!-- /col-lg-6 -->
            <div class="col-lg-6 col-lg-offset-1 col-md-6  col-sm-8 col-xs-12">
                <div class="input-group">
                <!-- <input type="text" name='name_product' :style="{'max-width':'130px', 'min-width':'120px'}" -->
                    <input type="text" name='name_product'
                                       v-model="search_name_product"
                                       class="form-control" 
                                       @input="searching_products_on_name"
                                       placeholder="название"
                    >
                    <span class="input-group-btn">
                         <button class="btn btn-default" type="button"
                             @click="searching_products_on_name">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"
                             @click="search_name_product=''"><span class="glyphicon glyphicon-remove"></span>
                       </button>
                    </span>
                    <input type='number'min='0.2' max='1.3' step='0.1' name="weight"
                                       v-model="search_weight_product"
                                       v-on:change = "searching_products_on_weight"
                                       v-bind:class ="{lightingRed:isNumber}"
                                        
                     class="form-control"  placeholder="вес">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"
                        @click="search_weight_product=''"  
                        >
                            <span class="glyphicon glyphicon-remove"></span></button>
                    </span>

                    <input type='number' min='0' max='20'class='form-control' placeholder="скидка" name='discount' size="3"
                                        v-model="disc_persent"
                                        >
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"
                            @click="disc_persent=''"
                        >
                        <span class="glyphicon glyphicon-remove"></span></button>
                    </span>

                <!-- /.input-group-->
                </div>
            </div><!-- /col -->    
        </div><!--end row -->   
    <div class="row" id="columns" :style="{'margin-top':'6px','margin-bottom':'3px'}">
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
    <div  class="row text-left">
        <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- <div class="table-responsive"> -->
                    <table v-show="products_search_lenght" class="table">
                        <thead><tr>
                            <th>
                                <!-- <div class="row"> -->
                                    <!-- <div class="col-lg-12"> -->
                                        <div class="input-group">
                                            <input type="text" class='form-control' 
                                                 v-bind:value="products_search_lenght" 
                                                 v-bind:style="styleObject"
                                            >
                                            <span class="input-group-btn">
                                                <button v-on:click="orderByName" class='btn btn-primary'>
                                                    <span v-if="sortNameDown" class='glyphicon glyphicon-sort-by-attributes'></span>
                                                    <span v-else class='glyphicon glyphicon-sort-by-attributes-alt'></span>
                                                    Sort name
                                                </button>
                                            </span>
                                            <span class="input-group-btn">
                                                <button v-on:click="orderByWeight" class='btn btn-primary'>
                                                    <span v-if="sortWeightDown" class='glyphicon glyphicon-triangle-top'></span>
                                                    <span v-else class='glyphicon glyphicon-triangle-bottom'></span>
                                                    Sort weight
                                                </button>
                                            </span>
                                            <!-- <span class="input-group-btn"> -->
                                            <input type='text' class='form-control' placeholder='name search'
                                                v-model="search_in_table_search" 
                                                v-on:change="show_in_table"
                                            >
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"
                                                        @click="search_in_table_search=''"
                                                    ><span class="glyphicon glyphicon-remove"></span>
                                                </button>
                                            </span>
                                            <!-- </span> -->
                                        </div><!-- /input-group  -->
                                    <!-- </div> -->
                                <!-- </div> -->
                            </th><th>расф.</th><th>ед. изм.</th><th>цена ед.</th><th>цена уп.</th><th>ост. ед.</th><th>ост. ящ</th></tr></thead>
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
                    <!--
                    <ul class="list-group">
                        <li class="list-group-tem"
                            v-for="prod in products_search">
                            {{prod.name}} brand-{{prod.id_brand}}  расфасовка:{{prod.pack_weight}} {{prod.pack_weight_name}} цена {{prod.price_for_one | discount(disc_persent) }}
                        </li>
                    </ul>
                    -->   
                </div>
            </div> 
            <!-- создание таблицы при считывании из файла -->  
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <?php 
                        $nameFile = 'price.csv';
                        if(is_file(__DIR__."/uploadFile/$nameFile")){
                            $textFilePriceCsv = new Text_csv_file($nameFile);
                            $date_price = $textFilePriceCsv->get_date_price();
                            echo"<script type='text/javascript'> var date_price = '$date_price'</script>";
                            if( $tableTovarAll = $textFilePriceCsv->createTableTovarFrom_csv_file('mytable')){
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

</body>
</html>
