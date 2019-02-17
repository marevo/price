<?php 
namespace App\Model;

class Product 
{
     public $id;
     public $name;
     public $unit;//единицы измерения шт, кг, блок
     public $Packaging;//расфасовка
     public $priceForUnit; //цена за единицу
     public $priceForPackaging; //цена за упаковку
     public $stockBalanceForUnit; //остаток на сладе в ед. измерения шт, кг, блок
     public $stockBalanceForPackaging; //остаток на складе в упаковках

     public function  __construct(){
          
     } 


}

