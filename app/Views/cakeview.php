
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300&display=swap" rel="stylesheet">
    <title>Cake Shop</title>

    <link rel="stylesheet" href="<?php echo base_url(); ?>/css/home.css">
    <script src="<?php echo base_url(); ?>/js/model.js"></script>
    
</head>
<body>
    <div class="head" style="position: fixed; top:0px; width: 100%;background-color: white;">
        <div class="logo">CAKE CHOW</div>
        <div class="nav">
            <a style="text-decoration: none; font-size: 18px" href="/" class="home c-vert">Home</a>
            <a style="text-decoration: none; font-size: 18px" href="/create/cake" class="create">Create</a>
        </div>
    </div>
    <div style="height: 100px"></div>
    
    <style>
        body, *{
            font-family: 'Barlow Condensed', sans-serif;
        }
        .cakeitem{
            width: 80%;
            max-width: 500px;
            border-radius: 5px;
            box-shadow: 0px 2px 3px grey;
            padding: 10px;
            position: relative;
            margin: 20px auto;
        }
        .cakeitem .maker{
            padding: 10px;
        }
        .cakeitem .bio .cakehead{
            font-size: 25px;
            padding: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .cakeitem .price{
            border-radius: 10px;
            top: 15px;
            right: 15px;
            padding: 10px;
            background-color: rgb(36 32 32 / 5%);
            color: black;
            font-weight: bold;
            position: absolute;
        }
        .cakeitem .recipe{
            padding: 10px;
            font-size: 18px;
        }
        .cakeitem .cakeoption{
            padding: 10px;
            display:flex;
            justify-content: space-between;
        }
        .cakeitem .cakeoption :nth-child(n){
            padding:10px;
            width: 24%;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .cakeitem .cakeoption :nth-child(n):hover{
            box-shadow: 0px 1px 8px -1px grey;
        }
    </style>

    <div id="app">
        <div v-for="entry in data">
            <div class="cakeitem">

                <div class="bio">
                    <span class="cakehead">{{entry['type']}}/{{entry['name']}}</span>
                    <span class="price">${{entry['price']}}</span>
                </div>
                <div class="maker">Made By: Alice White</div>

                <div class="recipe">{{entry['recipe']}}</div>

                <div class="cakeoption">
                    <div style="background-color: blue" class="edit" v-on:click="edit(entry['id'])">Edit</div>
                    <div style="background-color: red" class="delete" v-on:click="deleter(entry['id'])">Delete</div>
                    <div style="background-color: green" class="buy" v-on:click="buy(entry['id'])">Buy</div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://unpkg.com/vue@3.0.5"></script>
    <script>

        const app = Vue.createApp({
            mounted(){
                this.initiate()
            },
            data(){
                return {
                    data:{}
                }
            },
            methods:{
                initiate(){
                    new Cakemanager().findCake({
                        key:'id',
                        value:<?= $id ?>,
                    }, (response)=>{
                        this.data = response['data'];
                    })
                },
                edit(id){
                    window.location.href = location.origin + "/edit/cake/" + id;
                },
                deleter(id){
                    new Cakemanager().deleteCake(id, (response)=>{
                        window.location.href = location.origin
                    })
                },
                buy(){
                    alert('Item successfully added to your cart :)');
                },
            }
        })
        app.mount('#app');

    </script>
</body>
</html>