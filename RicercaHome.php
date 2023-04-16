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

            function inputControlDate(month, year){
                var date = new Date();
                yyyy = date.getFullYear();
                mm = date.getMonth() + 1;
                gg = date.getDate();
                year.trim();

                if(year === "" || year < yyyy || year === yyyy) {
                    document.getElementById("year").value = yyyy;
                    year = yyyy;
                    if(month < mm || month === ""){
                        document.getElementById("month").value = mm;
                        month = mm + 1;
                        //console.log(yyyy + "-" + mm + "-" + gg);
                        return yyyy + "-" + mm + "-" + gg;
                    }
                };
                if(month === "" || month < mm ) {
                    document.getElementById("month").value = mm;
                    // si aggiunge 1 perché in js i mesi partono da 0 mentre in php da 1
                    month = mm + 1;
                    //console.log(yyyy + "-" + mm + "-" + gg);
                    return yyyy + "-" + mm + "-" + gg;
                };
                //console.log(yyyy + "-" + mm + "-" + gg);
                return yyyy + "-" + mm + "-" + gg;
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
                        url:"Ricerca.php",
                        type:"POST",
                        data: ({product: inputControl($("#product").val()), model: inputControl($("#model").val()), amount: inputControlAmount($("#amount").val()), date:inputControlDate($("#month").val(),$("#year").val() ), flag : radioCheck($("#price").val())}),
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
                
                <div class="lable"> month       </div>
                <select name="month" id="month" style="width: 60px">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
                <input type="text" size="10" name="year" id="year" placeholder="year"><br>
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
