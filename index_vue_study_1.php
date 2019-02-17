<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue.js</title>
    <!-- production-версия, оптимизированная для размера и скорости-->
    <!-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->
    <script src = js/vue.js></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel='stylesheet' href='css/bootstrap.min.css'>
</head>
<body>
    <div class='wrapper'>
        <div class="sample">
        <button class='btn btn-primary' 
                    v-on:click="showH2=!showH2"
                    v-bind:title="showH2 ? 'hide':'show'"
                    >
                изменить
           </button>
           <button class='btn btn-primary' 
                    v-on:click="addNumber"
                    >
                add li
           </button>
            <!-- <input type="text" v-model='name'> -->
            <!-- <input type='text' v-bind:name='name' v-on:input> -->
            <input type='text' v-bind:name = "name" v-on:input = 'name = $event.target.value'>
            <hr>  
            <h2 v-show="showH2"> видно/не видно </h2>  
            <h2> Hello, {{name}} </h2>
            <h3>your profit {{sum}} </h3>
            <hr>
            <ul class="list-group">
                <li class="list-group-tem"
                    v-for="number in numbers">
                    {{number}}
                </li>
            </ul>
        </div>
    </div>
    <script>
    let sample = new Vue({
        el:'.sample',
        data:{
            name:'kuku',
            showH2:false,
            numbers:[1,2,3],
        },
        methods:{
            addNumber(){
                let rnd = Math.floor(Math.random()*11)-5;
                this.numbers.push(rnd);
            },
            
        },
        computed:{
            sum(){
                console.log('1');
                let sum=0;
                for(let i=0; i<this.numbers.length;i++){
                    sum += this.numbers[i];
                }
                return sum;
            }
        }
    });
    </script>
    
</body>
</html>