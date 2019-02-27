let table_vue = new Vue({
    el:'#container_main',
    data:{
        products:[],
        products_search:[],
        selected_brands:[],
        products_searching_selected_brands:[],//arr найденных продуктов по выделенному бренду (брендам)
        search_name_product:'',
        search_weight_product:'',
        size_all_obj:0,
        isNumber:true,
        input:'',
        sortNameDown:true,//сортировка по названию
        sortWeightDown:true,//сортировка по массе в ящике
        disc_persent:0,
        search_in_table:'',
        search_in_table_search:'',
        date_price:date_price,
        styleObject:{
            color:'#fff',
            backgroundColor:'#5f8eb6',
            width:'40px',
        },

        //brands что будут отображаться на странице index.php
        brands:[
            {id:'sweet_company',name:'Світ'},
            {id:'zhorik_obzhorik',name:'жорик'},
            {id:'sergis',name:'Сергис'},
            {id:'stimul',name:'Стимул'},
            {id:'lisovaKazka',name:'ЛК'},
            {id:'faraon',name:'Фараон'},
            {id:'zahid',name:'ЗАХІД'},
            {id:'R&V',name:'R&V'},
            {id:'lasoshi',name:'Ласощі'},
            {id:'shokoladno',name:'Шоколадно'},
    
        ],
        
    },
    methods:{
        create_all_products(){
            this.products.length = 0;
            let productss = this.products;
            $.each($('#mytable tbody tr'),function(){
                let product = {};
                product.id_brand = $(this).data('id_brand');
                product.name = $(this).find('td:nth-child(2)').text().toLowerCase();
                product.pack_weight = $(this).find('td:nth-child(4)').text();
                product.pack_weight_name = $(this).find('td:nth-child(3)').text().toLowerCase();
                product.price_for_one = $(this).find('td:nth-child(5)').text();
                product.price_for_unit = $(this).find('td:nth-child(6)').text();
                product.stock_balance_in_packaging = $(this).find('td:last').text();
                product.stock_balance_in_unit = $(this).find('td:last(-1)').text();
                productss.push(product);
            });
        },
        searching_products_on_name(){
            this.products_search.length=0;
            for(let i=0; i < this.products.length; i++){
                if(this.search_name_product !=='' 
                   &&  -1 !==  this.products[i].name.toLowerCase().indexOf(this.search_name_product.toLowerCase()) ){
                    this.products_search.push(this.products[i]);
                }
            }
        },
        searching_products_on_weight(){
            this.search_weight_product_number();
            if(this.isNumber){
                this.products_search.length=0;
                for(let i=0; i < this.products.length; i++){
                    if(this.search_weight_product !==''
                       && this.search_weight_product >= this.products[i].pack_weight 
                       && this.products[i].pack_weight_name == "кг" ){
                        this.products_search.push(this.products[i]);
                    }
                }
            }
            
        },
        searching_products_on_selected_brands(){
            this.products_search.length = 0;
            for(let i=0; i<this.products.length; i++){
                for(let j=0; j<this.selected_brands.length; j++){
                    if(this.products[i].id_brand == this.selected_brands[j].id ){
                        this.products_search.push(this.products[i]);
                    }
                }
                
            }
        },
        search_weight_product_number(){
            let rezult;
            if(rezult = parseFloat(this.search_weight_product)){
                this.isNumber = true;
                // return "число "+ rezult.toString();
            }
            else{
                this.isNumber = false;
                // return "строка " + this.search_weight_product ;
            }
            
        },
        orderByName(){
            let compared = this.sortNameDown = !this.sortNameDown;
            this.products_search.sort(compareName);
            // console.log("compared "+ compared + " "+this.sortNameDown);
            function compareName(productA, productB) {
                if(compared){
                    if(productA.name > productB.name)
                       return 1;
                    if(productA.name < productB.name)
                       return -1;
                    return 0;      
                }
                else{
                    if(productA.name < productB.name)
                       return 1;
                    if(productA.name > productB.name)
                       return -1;
                    return 0;
                }
            }
        },
        orderByWeight(){
            let compared = this.sortWeightDown = !this.sortWeightDown;
            this.products_search.sort(compareWeight);
            // console.log("compared "+ compared + " "+this.sortNameDown);
            function compareWeight(productA, productB) {
                if(compared){
                    if(productA.pack_weight > productB.pack_weight)
                       return 1;
                    if(productA.pack_weight < productB.pack_weight)
                       return -1;
                    return 0;      
                }
                else{
                    if(productA.pack_weight < productB.pack_weight)
                       return 1;
                    if(productA.pack_weight > productB.pack_weight)
                       return -1;
                    return 0;
                }
            }
        },
        show_tr(name){
            if(this.search_in_table_search !=''){
                let value =  this.search_in_table_search.toLowerCase();
                if(name.toLowerCase().indexOf(value) != -1){
                    return true;
                }else return false;
            }else return true;

        },
        show_in_table(){

        },
        clear_name_product(){
            // this.search_name_product = "";
        }
    },
    computed:{
        date_price_value(){
            return 'прайс от'+ this.date_price;
        },
        sum(){
            console.log('1');
            let sum=0;
            for(let i=0; i<this.numbers.length;i++){
                sum += this.numbers[i];
            }
            return sum;
        },
        // sizeObj_finding(){
        //    let size_all_finding_obj=0;
        //    this.size_all_obj = 0;
        //    for(let i=0;i<this.products.length;i++){
        //        this.size_all_obj +=sizeof(this.products[i]);
        //        for(let j=0;j<this.products_search.length;j++){
        //             if(this.products[i].name == this.products_search[j].name)
        //                size_all_finding_obj +=sizeof(this.products[i]);
        //        }
        //    }
        //    return size_all_finding_obj;
        // },
        products_length(){
            if(this.products != 'undefined')
               return this.products.length;
            return 0;   
        },
        products_search_lenght(){
            if(this.products_search !='undefined')
               return this.products_search.length;
            return 0;   
        },
        selected_brands_change(){
            this.products_search.length = 0;
            for(let i=0; i<this.products.length; i++){
                for(let j=0; j<this.selected_brands.length; j++){
                    if(this.products[i].id_brand == this.selected_brands[j].id ){
                        this.products_search.push(this.products[i]);
                    }
                }
                
            }
            // if(this.selected_brands.length>0)
            // this.searching_products_on_selected_brands();

            // if(this.products_search_lenght && this.products_search.length  > 0){
                // this.searching_products_on_selected_brands();
            // }
        }
    },
    filters:{
        discount(value,discount){
                if (discount ==' ' || discount == 0)
                    return 'p: '+ value ;
                value = parseFloat(value).toFixed(2);
                return  'p:' +value+' dis:'+ parseFloat(value - discount * parseFloat(value)/100).toFixed(2);
            // 100% value
            // discount% X 
            // x=value*discount/100
        },

    }

});