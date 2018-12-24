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
    <!-- <script type="text/javascript" src="js/jsSortSearchTable.js"></script>  -->
    <!-- <script type="text/javascript" src="js/jsForTable2.js"></script> -->


</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <header><h1>прайс</h1></header>
            <div class="form-group">
                <input type="text" class="form-control " id="search" placeholder="Поиск по таблице">
            </div>
            <div class="form-group">
                <input type="text" class="form-control " id="persent" placeholder="% скидка">
            </div>
        </div>
    </div>
    <div class="row class='text-left'">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            
            <div class="table-responsive">
                <?php 
                $row = 0;
                $pathToFile = './uploadFiles/price_09_12_18.csv';
                $table = "<table id='mytable' class = 'table table-striped table-hover'><thead><<>></thead>";
                if (($handle = fopen($pathToFile, "r")) !== false) {
                    // while (($data = fgetcsv($handle)) !== FALSE) {
                    $thead = "";
                    while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                        $num = count($data);
                        $name = $data[0];
                        $td_all = "";//все <td> для одной строки
                        $tr = "";
                        // echo "<p> $num fields in line $row: <br /></p>\n";
                        $row++;
                        $c = 0;
                        // if($row == 7)
                            // break;
                        //3 первых строки это заголовок и название колонок 
                        //оформим из в тэги <thead></thead>
                        if ($row < 3) {
                            // $tr = "<thead><tr></tr></thead><tbody>";
                            for (; $c < $num; $c++) {
                                $td_all .= "<td>" . $data[$c] . "</td>";
                                // echo $data[$c] . "<br />\n";
                            }
                            $thead .= "<tr><td>$row</td>$td_all</tr>";
                        } else {
                            if ($row == 284) {
                                $stop = "stop";
                            }
                            //это идут строки в <tbody></tbody>
                            for (; $c < $num; $c++) {
                                //если рассматриваем 1 колонку (название товара) и встречаем в ней * и символы шт/ | ш/ | шт
                                //значит это товар идет в блоках и надо вычислить сколько товара в блоке (обычно выглядит так *50шт | *24шт/ | * 28ш)
                                // if($c == 0  && strripos($data[$c],'*')  &&   ( strpos($data[$c],'шт/') || strpos($data[$c],'ш/')  || strpos($data[$c],'шт'))  ){
                                if ($c == 0 && strripos($name, '*') && (strpos($name, 'шт/') || strpos($name, 'шт') || strpos($name, 'ш/'))) {
                                    // string substr(string string, int start[, int length]);
                                    $posZV = strripos($name, '*');//позиция звездочки
                                    //позиция 'шт'
                                    $posSHT = strripos($name, 'шт/') ? strripos($name, 'шт/') : strripos($name, 'шт') ? strripos($name, 'шт') : strripos($name, 'ш/');
                                    if ($posSHT > $posZV) {
                                        $countItemInPack = substr($name, $posZV + 1, $posSHT - $posZV - 1);
                                        $countItemInPackInteger = intval($countItemInPack);
                                        if ($countItemInPackInteger) {
                                            $priceItem = round($data[3] / $countItemInPackInteger, 2);
                                            $td_all .= "<td>" . $data[$c] . "<i class='sht'> за/шт $priceItem </i> </td>";
                                        }
                                    } else
                                        $td_all .= "<td>$data[$c]</td>";
                                } else{
                                   if($c == 3){
                                    $td_all .= "<td data-base_price ='$data[$c]'>$data[$c]</td>";
                                   }
                                   else
                                       $td_all .= "<td>$data[$c]</td>";
                                }
                                   // $td_all .= "<td>$data[$c]</td>";
                                // echo $data[$c] . "<br />\n";
                            }
                            $tr .= "<tr><td>$row</td>$td_all</tr>";
                            $table .= $tr;
                        }
                    }
                    $table = str_replace("<<>>", $thead, $table);
                    $table .= "</tbody></table>";
                    fclose($handle);
                    echo "$table";
                }
                ?>
            </div>
        </div>
    </div>
<!-- container end -->    
</div>
<script type="text/javascript" src="js/index.js"></script>
</body>
</html>
