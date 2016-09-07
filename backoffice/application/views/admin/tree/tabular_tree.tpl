<html xmlns="https://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Tabular Tree View</title>
	<script type="text/javascript" src="{$PUBLIC_URL}javascript/jquery.js"></script>
	<script type="text/javascript" src="{$PUBLIC_URL}javascript/jquery.cookie.js"></script>
	<script type="text/javascript" src="{$PUBLIC_URL}javascript/jquery.hotkeys.js"></script>
	<script type="text/javascript" src="{$PUBLIC_URL}javascript/jquery.jstree.js"></script>

	<style type="text/css">
	html, body { margin:0; padding:0; }
	body, td, th, pre, code, select, option, input, textarea { font-family:verdana,arial,sans-serif; font-size:10px; }
	.demo, .demo input, .jstree-dnd-helper, #vakata-contextmenu { font-size:10px; font-family:Verdana; }
	#container { width:775px; margin:10px auto; overflow:hidden; position:relative; }
	#demo { width:auto; height:500px; overflow:auto; border:1px solid gray; }

	#text { margin-top:1px; }

	#alog { font-size:9px !important; margin:5px; border:1px solid silver; }
	</style>
</head>
<body style="z-index:0;">
    <table align="center" >
        <tr><td colspan="2">
<input type = 'hidden' value = '1' name = 'user_id'  id = 'user_id'>
<div id="container" style="bgcolor:white">
    
    <table width="100%">
		<tr>
			<td bgcolor='#FFFFEE'>	
				<label bgcolor='#999'> <img src="{$PUBLIC_URL}images/root.png" /><b>[{$user_name}]</b></label>
			</td>
			<td align="right">
                                {form_open('', 'method="post" id="find_form" name="find_form"')}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="" name="go_id" id="go_id"><input type="submit" value="Find Id" name="go_submit">
				{form_close()}
			</td>
	
		</tr>
	</table>
    <div id="demo" class="demo">
    

</div>
<!-- JavaScript neccessary for the tree -->
<script type="text/javascript">
$(function () {
        /*var id;
        if(n.attr)
        id = n.attr("id");        
            else
        id = {$user_id};*/
    
	// Settings up the tree - using $(selector).jstree(options);
	// All those configuration options are documented in the _docs folder
      
	$("#demo")
		.jstree({ 
			// the list of plugins to include
			"plugins" : [ "themes", "json_data", "ui", "crrm", "cookies", "dnd", "search", "types", "hotkeys", "contextmenu" ],
			// Plugin configuration


			// I usually configure the plugin that handles the data first - in this case JSON as it is most common
			"json_data" : { 
				// I chose an ajax enabled tree - again - as this is most common, and maybe a bit more complex
				// All the options are the same as jQuery's except for `data` which CAN (not should) be a function
				"ajax" : {
					// the URL to fetch the data
					//"url" : "{$PATH_TO_ROOT}/admin/tree/get_children/{$user_id}",
                                        
                                        
                                        "url" : "{$BASE_URL}server.php",
                                        //"url" : "{$PATH_TO_ROOT_DOMAIN}public/server.php",
					// this function is executed in the instance's scope (this refers to the tree instance)
					// the parameter is the node being loaded (may be -1, 0, or undefined when loading the root nodes)
					
                                        "data" : function (n) {
                                            //alert(n.attr("id"));
						// the result is fed to the AJAX request `data` option
						return {                        				
							
							"id" : n.attr ? n.attr("id"):{$user_id}
						}; 
					}
                                       
                               
                                       
				}
			},
			// Configuring the search plugin
			"search" : {
				// As this has been a common question - async search
				// Same as above - the `ajax` config option is actually jQuery's object (only `data` can be a function)
				"ajax" : {
					"url" : "./server.php",
					// You get the search string as a parameter
					"data" : function (str) {
						return { 
							"operation" : "search", 
							"search_str" : str 
						}; 
					}
				}
			},
			// Using types - most of the time this is an overkill
			// Still meny people use them - here is how
			"types" : {
				// I set both options to -2, as I do not need depth and children count checking
				// Those two checks may slow jstree a lot, so use only when needed
				"max_depth" : -2,
				"max_children" : -2,
				// I want only `drive` nodes to be root nodes 
				// This will prevent moving or creating any other type as a root node
				"valid_children" : [ "drive" ],
				"types" : {
					// The default type
					"default" : {
						// I want this type to have no children (so only leaf nodes)
						// In my case - those are files
						"valid_children" : "none",
						// If we specify an icon for the default type it WILL OVERRIDE the theme icons
						"icon" : {
						
							"image" : "{$PUBLIC_URL}images/file.png"
						}
					},
					// The `folder` type
					"folder" : {
						// can have files and other folders inside of it, but NOT `drive` nodes
						"valid_children" : [ "default", "folder" ],
						"icon" : {
							"image" : "{$PUBLIC_URL}images/add_1.png"
						}
					},
					
					"notactive" : {
						// can have files and other folders inside of it, but NOT `drive` nodes
						"valid_children" : [ "default", "folder" ],
						"icon" : {
							"image" : "{$PUBLIC_URL}images/root.png"
						}
					},
					// The `drive` nodes 
					"drive" : {
						// can have files and folders inside, but NOT other `drive` nodes
						"valid_children" : [ "default", "folder" ],
						"icon" : {
							"image" : "{$PUBLIC_URL}images/root.png"
						},
						// those options prevent the functions with the same name to be used on the `drive` type nodes
						// internally the `before` event is used
						"start_drag" : false,
						"move_node" : false,
						"delete_node" : false,
						"remove" : false
					}
				}
			},
			// For UI & core - the nodes to initially select and open will be overwritten by the cookie plugin

			// the UI plugin - it handles selecting/deselecting/hovering nodes
			"ui" : {
				// this makes the node with ID node_4 selected onload
				"initially_select" : [ "node_4" ]
			},
			// the core plugin - not many options here
			"core" : { 
				// just open those two nodes up
				// as this is an AJAX enabled tree, both will be downloaded from the server
				"initially_open" : [ "node_2" , "node_3" ] 
			}
		})

	

});
</script>
<script type="text/javascript">
$(function () { 
	$("#mmenu input").click(function () {

		switch(this.id) {
			case "add_default":
			case "add_folder":
				$("#demo").jstree("create", null, "last", { "attr" : { "rel" : this.id.toString().replace("add_", "") } });
				break;
			case "search":
				$("#demo").jstree("search", document.getElementById("text").value);
				break;
			case "text": break;
			default:
				$("#demo").jstree(this.id);
				break;
		}
	});
});
</script>
</div>
</td></tr>
        </table>
</body>
</html>