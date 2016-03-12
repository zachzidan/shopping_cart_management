

/* USING AJAX IN OUR ASSIGNMENT
EVERY PAGE NEEDS TO HAVE 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="shoppingCartManagement.js" type="text/javascript"></script>
IN THE HEADER
*/


function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 

document.onkeypress = stopRKey; 



function disabledButton(){
	$('#addToCartButton').prop('disabled', false);
	$( ".attributes" ).each(function( index ) {
		if($(this).val() >0){
		
		}else{
		$('#addToCartButton').prop('disabled', true);
		}
	});	


}




$( document ).ready(function() {
	var pathname = window.location.pathname;
	disabledButton();
	

	var myVar;
	if(pathname == "/Assignment%202/DisplayShoppingCart.php"){
		
		$('#cartButton').hide();
	}else{
	getCart();
	}
	});

function showFloatingCart(x) {
	
	$('#floatingCart').show();
	if( x == "new"){
	clearTimeout(myVar);
	}else{
	myVar = setTimeout(function(){ $('#floatingCart').fadeOut(1200); }, 4000);
	}
}
function hideFloatingCart(x) {
	$('#floatingCart').hide();
}

function slideFloatingCart(x) {
	
	$('#floatingCart').slideDown(500);
	if( x == "new"){
	clearTimeout(myVar);
	}else{
	myVar = setTimeout(function(){ $('#floatingCart').fadeOut(1200); }, 4000);
	}

}



/*

<form id="PRODUCT_ID" onsubmit="AddToCart(); return false">

	~~ U CAN PUT ANYTHING U WANT HERE
	
	<input type="submit" value="Add to Cart">
</form>

If you want to use a different format, please contact me at zachariah.zidan@students.mq.edu.au
*/
function AddToCart() {
	var str = $("#PRODUCT_ID").serialize();
    if (str.length == 0) { 
		//THIS RETURNS IF NO DATA IS SENT

        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//RETURNS WHAT IS ON THE RESPONSE FROM THE SERVER< CAN BE EDITTED TO MAKE THINGS HAPPEN IN JS

				getCart();
				slideFloatingCart("blank");
				
            }
        }
        xmlhttp.open("POST", "AddToCart.php?" + str, true);
        xmlhttp.send();	
    }
}



/*

<button value=".$OP[$row][0]." name='remove' onclick='RemoveFromCart(this.value); return false'>Remove</button>
 If you want to use a different format, please contact me at zachariah.zidan@students.mq.edu.au
*/

function RemoveFromCart(str) {
	

    if (str.length == 0) { 
		//THIS RETURNS IF NO DATA IS SENT
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//RETURNS WHAT IS ON THE RESPONSE FROM THE SERVER< CAN BE EDITTED TO MAKE THINGS HAPPEN IN JS
                location.reload();
            }
        }
        xmlhttp.open("POST", "RemoveFromCart.php?OP_id=" + str, true);
        xmlhttp.send();	
    }
}


/*


	<input name='quantity' onblur='ChangeQuantity(".$OP[$row][0].", this.value)' type='text' value='".$OP[$row][4]."'>

 If you want to use a different format, please contact me at zachariah.zidan@students.mq.edu.au
*/

function ChangeQuantity(x, y) {

	var str = "OP_id=" + x + "&OP_qty=" + y;

    if (str.length == 0) { 
		//THIS RETURNS IF NO DATA IS SENT
        
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//RETURNS WHAT IS ON THE RESPONSE FROM THE SERVER< CAN BE EDITTED TO MAKE THINGS HAPPEN IN JS
                location.reload();
            }
        }
        xmlhttp.open("POST", "ChangeQuantity.php?" + str, true);
        xmlhttp.send();	
    }
}




function getCart() {
	var str = "hello"
    if (str.length == 0) { 
		//THIS RETURNS IF NO DATA IS SENT
        document.getElementById("floatingCart").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//RETURNS WHAT IS ON THE RESPONSE FROM THE SERVER< CAN BE EDITTED TO MAKE THINGS HAPPEN IN JS
                document.getElementById("floatingCart").innerHTML = xmlhttp.responseText;
				
            }
        }
        xmlhttp.open("POST", "getCart.php?" + str, true);
        xmlhttp.send();	
    }
}



