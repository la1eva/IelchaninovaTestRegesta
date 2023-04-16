<!DOCTYPE html>
<html>
    <head>
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href="style.css">
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
       <script>
            
            function inputControlAmount(input){
                if(!isNaN(input) && input >= 1){
                    input = Math.floor($("#amount").val());
                    document.getElementById("amount").value = input;
                    //console.log(input);
                    return input;
                        
                }else{
                    if(!isNaN(input)){alert("Insert a number");}
                    return $("#information").text("Please, insert the amount");

                }
            }

            function inputControl(input){
                if(input != "")
                    return input.trim();
                return $("#information").text("Please, insert the what you are looking for");
            }

            function inputControlDate(date){
                var today = new Date();
                yyyy = today.getFullYear();
                mm = today.getMonth() + 1;
                gg = today.getDate();
                today = yyyy + "-0" + mm + "-" + gg; 
                console.log(today); //2023-4-16
                console.log(date); //2023-04-22
                if(date < today || date === null){
                    document.getElementById("date").value = today;
                    return today; 
                }
                return date;

            }



           
            function funcSuccess(data){
                if(data == "fail"){
                    $("#information").text("We don't have this model in our stock. Check if your input is corect");
                }else{
                    //console.log(data);
                    $("#information").text(data);
                }     
            }

            function funcBefore(){
                $("#information").text("loading");
            }

            function radioCheck(value){
                if( $('#price').get(0).checked ){
                    return 1;
                }
                return 0;
            }

            $(document).ready(function(){
                
                $("#submit").bind("click",function(){
                    var flag = $("#flag1").val();
                    console.log(flag);
                    $.ajax({
                        url:"ricercaProva.php",
                        type:"POST",
                        data: ({product: inputControl($("#product").val()), model: inputControl($("#model").val()), amount: inputControlAmount($("#amount").val()), date:inputControlDate($("#date").val()), flag : radioCheck($("#price").val())}),
                        dataType:"html",
                        beforeSend: funcBefore,
                        success: funcSuccess 
                       
                    });
                });
            });
        </script>

    </head>
  
    <body class="index">
        <div class="title">
            <h1>Marketplace</h1> 
        </div>

        <div class = "container">
            <div class="assigment">WHAT ARE YOU LOOKING FOR AND BY WHEN</div>
            
            <div class="search-bar">
                <input type="text" size="10" maxlength="50" name="product" id="product" placeholder="Product*"><br>
                <input type="text" size="10" maxlength="50" name="model" id="model" placeholder="model*" ><br>
                <input type="text" pattern="^[0-9]*$" size="10" maxlength="4" name="amount" id="amount" placeholder="amount*" ><br>
                
                <input type="date" id="date"><br>
                <div class="flag-container">
                    Best 
                    <input type="radio" id="price" name="delivery" value="1" >delivery</label>
                    <input type="radio" id="delivery" name="delivery" value="0"><label for="delivery">price</label>
                </div>
                <button id="submit" type="submit" name="submit" value="Search"><img src="images/search.png" ></button>

            </div>
           
            
            <div class="output-container">
                <p class="output" id="information"></p></div>
            </div> 
            
        
        </div>
        
     
        
      

        
    </body>
</html>
