$(document).ready(function() {
    $('#countdown_box').hide();
//$.uiLock('');
});


function getDetails(frm)
{
    //$('#countdown_box').show();
    //$.uiLock('');

    loader = frm.loader;
    showLoader(loader);
    var qty = frm.qty.value;
    var pdtid = frm.pdtid.value;
    $.getJSON("../update_cart/" + pdtid + '/' + qty, function(json) {

	var amt = CommaFormatted(CurrencyFormatted(json.total));
	var message_dis = json.message;
	$("#items").html(json.count);
	$("#amount").html(amt);
	$("#ajax_msg").html(message_dis);
    });

    hideLoader(loader);
    //$('#countdown_box').hide();
    //$.uiUnlock();
    return false;
}

function removeProduct(id)
{
    var msg = $("#msg1").html();
    var base_url = $("#base_url").val();
    if (confirm(msg))
    {
	document.location.href = base_url + 'user/shopping/remove_item/' + id;
    }
}

function checkout()
{
    var msg = $("#msg2").html();
    var base_url = $("#base_url").val();
    if (confirm(msg))
    {
	document.location.href = base_url + 'user/shopping/checkout';
    }
}

function removeAll()
{
    var msg = $("#msg3").html();
    var base_url = $("#base_url").val();
    if (confirm(msg))
    {
	document.location.href = base_url + 'user/shopping/remove_all/true';
    }
}

function updateQuantity(frm)
{
    var qty = frm.qty.value;
    var pdtid = frm.pdtid.value;
    var sub = '#' + pdtid + 1;
    $.getJSON("../../shopping/update_qty/product_id/" + pdtid + "/qty/" + qty, function(json) {
	var status = json.status;
	if (status == 1)
	{
	    var amt = CommaFormatted(CurrencyFormatted(json.total));
	    var sub_amt = CommaFormatted(CurrencyFormatted(json.sub));
	    $("#amount").text(amt);
	    $(sub).text(sub_amt);
	}
	else
	{
	    location.reload();
	}
    });

    return false;
}


function hideLoader(loader)
{
    loader.style.display = "none";
}
function showLoader(loader)
{
    loader.style.display = "block";
}

function CommaFormatted(amount)
{
    var delimiter = ","; // replace comma if desired
    var a = amount.split('.', 2)
    var d = a[1];
    var i = parseInt(a[0]);
    if (isNaN(i)) {
	return '';
    }
    var minus = '';
    if (i < 0) {
	minus = '-';
    }
    i = Math.abs(i);
    var n = new String(i);
    var a = [];
    while (n.length > 3)
    {
	var nn = n.substr(n.length - 3);
	a.unshift(nn);
	n = n.substr(0, n.length - 3);
    }
    if (n.length > 0) {
	a.unshift(n);
    }
    n = a.join(delimiter);
    if (d.length < 1) {
	amount = n;
    }
    else {
	amount = n + '.' + d;
    }
    amount = minus + amount;
    return amount;
}


function CurrencyFormatted(amount)
{
    var i = parseFloat(amount);
    if (isNaN(i)) {
	i = 0.00;
    }
    var minus = '';
    if (i < 0) {
	minus = '-';
    }
    i = Math.abs(i);
    i = parseInt((i + .005) * 100);
    i = i / 100;
    s = new String(i);
    if (s.indexOf('.') < 0) {
	s += '.00';
    }
    if (s.indexOf('.') == (s.length - 2)) {
	s += '0';
    }
    s = minus + s;
    return s;
}