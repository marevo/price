<?php
namespace App\Model;

class Brand{

/**
 * @param array $all_brands assoc array, type string key is name of brand = name_brand_in_csv_file,  type string value is id_brand   
 */
private static $all_brands  = 
[    
    //
    //название в строке наименования товара => id_brand

    'Vavryk&Co'=>'vavryk',
    'ВАВРИК'=>'vavryk',
    'Диканське'=>'dikanske',

    'ЖОРИК ОБЖОРИК'=>'zhorik_obzhorik',
    'Жор. Обж'=>'zhorik_obzhorik',
    'ЖорОбж'=>'zhorik_obzhorik',
 
    'ЗАХІД'=>'zahid',
    'Ласощі'=>'lasoshi',
    'ТМ ЛК'=>'lisovaKazka',
    'яфасовка' => 'lisovaKazka',
    'Світ Компані'=>'sweet_company',
    'Сергис'=>'sergis',
    'Стимул'=>'stimul',
    'R&V' => 'R&V',
    'Фараон'=>'faraon',
    'Шоколадно' =>'shokoladno',
    

    'ЛУСКУНЧИК тм' => 'luskunchik',
    'ЛУСКУНЧИК' => 'luskunchik',
    'Лускунчик' => 'luskunchik',
    'Океан изобилия' =>'oceanYzobylya',
    'ОІ' => 'oceanYzobylya',
    'ОТТИМО' => 'ottimo',
    'ОТТІМО' => 'ottimo',
];

/**
     * @param string $data_string строка первого распарсеного столбца в таблице csv file
     * @return string if exist | false if not exist brand in array Brand::all_brands 
     */
    public static function get_brand_id(string $data_string):string{
        $data_string_lower_string = mb_strtolower($data_string);
        $brand_name = "";
        $brand_id = "";
        foreach(self::$all_brands as $brand_key => $brand_value){
            $brand_key_lower_string = mb_strtolower($brand_key);
            $pos = strpos($data_string_lower_string,$brand_key_lower_string);
            if($pos === 0 ||  $pos  ){
                $brand_name = $brand_key;
                $brand_id = $brand_value;
                break;
            }
        }
        if($brand_name && $brand_id)
            return $brand_id;
        return "not_find_brand"; 
    }

}
