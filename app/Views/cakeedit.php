
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
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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

    <div style="font-size: 30px;text-decoration:underline; font-weight: bold; padding: 10px"><?php if($access_type == 'create'){echo "Create a new cake package";}else{echo "Editing cake package";}?></div>

    
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

    <div class="authpack" id='cakename'>
        <h3 class="authtype">Cake Name</h3>
        <div style="display: flex; justify-content: space-between; margin: 10px 0px;">
            <input  style="width: 100%" type="text" placeholder="Enter cake name" value="<?php if (isset($name)) {echo $name;} ?>">
        </div>    
    </div>

    <div class="authpack" id='authcred'>
        <div style="display: flex; justify-content: space-between; margin: 10px 0px;">
            <div style="width: 45%" >
                <h4 >Type</h4>
                <input id='type' type="text" placeholder="Enter cake type" value="<?php if (isset($type)) {echo $type;} ?>">
            </div>
            <div style="width: 45%" >
                <h4>Price</h4>
                <input  id='price' type="number" placeholder="Enter cake price" value="<?php if (isset($price)) {echo $price;} ?>">
            </div>
        </div>  

        <h3 class="authtype">Cake Recipe</h3>
        <div style="display: flex; justify-content: space-between; margin: 10px 0px;">
            <textarea id="recipe"  style="width: 100%; resize:none; height: 100px; outline:none; border:2px solid black; font-size: 18px; border-radius: 5px; padding: 5px" type="text" placeholder="Story of the making..."> <?php if (isset($recipe)) {echo $recipe;} ?> </textarea>
        </div>

        <div style="width: 100%" type='cred' class="c-vert confirm">Confirm</div>       
    </div>
    

    
    <style>
        .c-vert{
            display: flex;
            justify-content: center;
            flex-direction:column;
        }
        .authpack *{
            box-sizing: border-box;
        }
        .authpack{
            margin: 10px auto;
            margin-top: 45px;
            max-width: 60%;

        }
        .authpack input{
            outline: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .authpack .confirm{
            border-radius: 10px;
            padding: 10px;
            background-color: green;
            text-align: center;
            min-height: 50px;
            min-width: max-content;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .authpack .confirm:hover{
            background-color: rgb(5, 41, 5);
        }
        .authpack h4{
            padding: 5px;
            margin:0px;
        }
        input{
            font-size: 18px;
        }


        

    </style>

    <script>
        let atype = '<?php echo  $access_type ?>'
        $('.confirm').click(function(){
            let mdata = {};
            
            data = {
                name: $('#cakename input').val(),
                price: parseInt($('#price').val()),
                type: $('#type').val(),
                recipe: $('#recipe').val(),
            }

            if (atype == 'edit'){
                new Cakemanager().updateCake(<?php if (isset($id)){echo $id; echo ',';}  ?>data, (response)=>{
                    console.log(response);
                    window.location.href = location.origin;
                })
            }
            if (atype == 'create'){
                new Cakemanager().createCake(data, (response)=>{
                    console.log(response);
                    window.location.href = location.origin;
                })
            }
        })
    </script>
</body>
</html>