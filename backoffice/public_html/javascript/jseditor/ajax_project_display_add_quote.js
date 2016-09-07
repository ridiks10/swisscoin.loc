
function getProjects()
{
    var cus_id = document.save_cust_invoice.customer_ID.value;


     var strURL="../customer/ajax_customer_project_invoce/cust_id:"+cus_id;
		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {
                                              //  alert(trim(req.responseText));
                                              var response =trim(req.responseText);
                                              var response_array= response.split("###");
                                              var poject = response_array[0];
                                               var balance = response_array[1];

						document.getElementById('project_div').innerHTML=trim(poject);
                                              //  document.getElementById('balance').innerHTML=trim(balance);

					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}
			}
			req.open("GET", strURL, true);
			//alert(strURL);
			req.send(null);
		}


}

function trim(a)
	{

	  return a.replace(/^\s+|\s+$/,'');
	}

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{
			try{
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}

		return xmlhttp;
    }

