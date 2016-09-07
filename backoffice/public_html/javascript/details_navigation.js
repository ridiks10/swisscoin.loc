function getNextItem()
{
	var cat_id = document.getElementById('cat_id').value;
	var pdt_id = document.getElementById('pdtid').value;
	var imgPath = document.getElementById('path').value;
	var nxt = document.getElementById('nxtid').value;
	
	if(nxt)
		{
			$.getJSON("../get_next_item/next:"+pdt_id+"/cat:"+cat_id, function(json){	
			$('#jspdt').html(json.product);
			$('#jsbrand').html('&nbsp;&nbsp;'+json.brand);
			var price = CommaFormatted(CurrencyFormatted(json.price));
			$('#jsprice').html('&nbsp;&nbsp;INR&nbsp;&nbsp;'+price);
			var tax = CommaFormatted(CurrencyFormatted(json.tax));
			$('#jstax').html('&nbsp;&nbsp;'+tax+'%');
			var img = "<img src="+imgPath+json.thumb+">";
			$('#jsimage').html(img);
			$('#jspdtnm').html(json.product);
			$('#jsfet').html(json.featurs);
			$('#jsdes').html(json.description);
			document.getElementById('pdtid').value=json.id;
			document.getElementById('nxtid').value=json.next_id;
			document.getElementById('prvid').value=json.prev_id;
			$('#msg').html('');
			});
		}
		else
		{
			$('#msg').html('No more products!');
		}
}

function getPreviousItem()
{
	var cat_id = document.getElementById('cat_id').value;
	var pdt_id = document.getElementById('pdtid').value;
	var imgPath = document.getElementById('path').value;
	var prv = document.getElementById('prvid').value;
	
	if(prv)
		{
			$.getJSON("../get_previous_item/previous:"+pdt_id+"/cat:"+cat_id, function(json){	
			$('#jspdt').html(json.product);
			$('#jsbrand').html('&nbsp;&nbsp;'+json.brand);
			var price = CommaFormatted(CurrencyFormatted(json.price));
			$('#jsprice').html('&nbsp;&nbsp;INR&nbsp;&nbsp;'+price);
			var tax = CommaFormatted(CurrencyFormatted(json.tax));
			$('#jstax').html('&nbsp;&nbsp;'+tax+'%');
			var img = "<img src="+imgPath+json.thumb+">";
			$('#jsimage').html(img);
			$('#jspdtnm').html(json.product);
			$('#jsfet').html(json.featurs);
			$('#jsdes').html(json.description);
			document.getElementById('pdtid').value=json.id;
			document.getElementById('nxtid').value=json.next_id;
			document.getElementById('prvid').value=json.prev_id;
			$('#msg').html('');
			});
		}
		else
		{
			$('#msg').html('No more products!');
		}
	
}

function getSelImage(value)
{
    var path = value;
    document.getElementById('imgpath').value=path;
    
    var a = document.getElementById('imgpath').value;
  
  
 

    //alert(a);
}

