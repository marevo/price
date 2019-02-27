<?php
namespace App\Model;
require_once "Brand.php";
// require_once "Exception";

class Text_csv_file
{
    public $pathToFile;
    private $handle;//resurs on file type csv
    private $nameFile;//name file type csv in uploadFiles
    private $error_message_notfile;
    private $error_message;
    private static $error_mes_noFile = "нет такого файла в uploadFiles";
    private static $error_mes_noNameFileInConstruct = "не передано имя в конструктор";
    private $arrOfProducts = []; //массив товаров
    
   /**
    * @param string  $_nameFile name of file with extend csv
   */
    public function __construct(string $_nameFile = null){
        if($_nameFile){
            $this->nameFile = $_nameFile;
            try{
                if(is_file("uploadFile/$this->nameFile"))
                    $this->pathToFile = "uploadFile/$this->nameFile";
            }catch(Exception $exception){
                    $this->error_message .= $exception . " $this->nameFile";
                     echo $exception->getMessage()." $error_mes_noFile ";
            }
        }else{
            var_dump ("! ".self::$error_mes_noNameFileInConstruct);
        }
    }

    private function get_handle_cvs_file(){
        if ( is_file( $this->pathToFile) && false !== ($this->handle = fopen($this->pathToFile, "r"))  )
           return $this->handle;
        return null;   
    }

    /**
     *@returt string like "10.02.19" 
     */
    public function get_date_price():string{
        //sting of file.csv
        $row = 0;
        if($this->get_handle_cvs_file()){
            while(($data = fgetcsv($this->handle, 1000, ';')) !==false && $row < 2){
                $data = self::encodWinToUtf8($data);
                //$num количество подстрок в строке разделенной ";" в файле csv
                $num = count($data);
                $td_0 = $data[0];//fisrst substring in string
                if($row == 0){
                   //смотрим первую строку файла (вид  "Прайс на дату: 10.02.19;;;;;;")
                   //найдем строку даты после ":"
                   if($pos_begin = strpos($td_0,":")){
                       fclose($this->handle);
                       return substr($td_0,$pos_begin);
                   }
                }
                fclose($this->handle);
            }
        }
        return " !no_date";
    }

    /** 
     * @return string 
     * @param string $idTable id of table to view on client-mashine
     */
    public function createTableTovarFrom_csv_file(string $idTable = null){
        $table = "<table id='$idTable' class = 'table table-striped  table-hover'><thead><<>></thead>";
        $thead = "";
        $row = 0;

        if ( $this->get_handle_cvs_file()){
            while (($data = fgetcsv($this->handle, 1000, ';')) !== false) {
                $data = self::encodWinToUtf8($data);
                //$num количество строк в файле csv
                $num = count($data);
                $name = $data[0];
                // найдем id бренда в просматриваемой строке через массив статич перем класса Brand $all_brands ключ => значение брендов в классе Brand.php
                $brand_id = Brand::get_brand_id($name);
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
                    if($row ==1 ){
                        //заполнение названия и даты типа      Прайс на дату: 12.01.19	
                        $thead .= "<tr><td>$row</td>$td_all</tr>";
                        $table = str_replace("<<>>", $thead, $table);

                    }else{
                        //добавка наименования колонок типа 
                        //Наименование	ед.изм	расф.	Цена с НДС за ед.	Цена с НДС за упаковку	Останок по складу (ед)	Останок по складу (расф.)
                        $table = str_replace("</thead>","<td>$row</td>".$td_all.'</thead>', $table);
                    }
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

                    $tr .= "<tr data-id_brand = '$brand_id' ><td>$row</td>$td_all</tr>";
                    $table .= $tr;
                }
            }
            $table .= "</tbody></table>";
            fclose($this->handle);
            return $table;
        }
        // fclose($this->handle);
        $errorMessage ="какая-то ошибка при формировании таблицы"; 
        return "<table id='$idTable' class = 'table table-striped table-hover'><thead></thead><tbody><tr><td>$errorMessage</td></tr></tbody></table>";
    }
    /**
     * @return array from string like " date : 22.11.2018; ; ; ; ; ;"
     */
    public static function encodWinToUtf8(array $strWin):array{
        $arrayToreturn = [];
        $arrCount = count($strWin);
        for($i = 0;$i < $arrCount; $i++){
            $arrayToreturn[] = mb_convert_encoding($strWin[$i],'UTF-8','Windows-1251');
        }
        return $arrayToreturn;
    }
}
