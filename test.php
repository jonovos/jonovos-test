<html>



<head>

<style type="text/css">

#editor {
    position: relative;
    left:0px;
    top:0px;
    width: 720px;
    height: 710px;
}

.st_dir
{
    color:#0000ff;
}

.st_file
{
    color:#400000;
    background-color:#ffffc0;
}
.st_file:hover
{
    background-color:#ffc0c0;
    cursor:pointer;
}

</style>


<!-- JAVASCRIPT INCLUDES -->
<script type="text/javascript" charset="utf-8"
        src="src/ace.js"></script>
<script type="text/javascript" charset="utf-8"
        src="src/theme-vibrant_ink.js"></script>

<script type="text/javascript" charset="utf-8"
        src="src/mode-text.js"></script>
<script type="text/javascript" charset="utf-8"
        src="src/mode-javascript.js"></script>
<script type="text/javascript" charset="utf-8"
        src="src/mode-php.js"></script>
<script type="text/javascript" charset="utf-8"
        src="src/mode-html.js"></script>
<script type="text/javascript" charset="utf-8"
        src="src/mode-json.js"></script>
<script type="text/javascript" charset="utf-8"
        src="src/mode-xml.js"></script>


<script type="text/javascript">

var editor;
window.onload = function()
 {
    var JavaScriptMode = require("ace/mode/javascript").Mode;

    editor = ace.edit("editor");
    editor.setTheme("ace/theme/vibrant_ink");
    editor.getSession().setMode( new JavaScriptMode() );
    editor.setShowPrintMargin(false);
};

var editor_changed = false;
function editor_onChanged()
{
    if( ! editor_changed )
    {
        editor_changed = true;
        d = document.getElementById( "id_changed" );
        d.innerHTML = "<b>*changed*</b>";
    }
}
function editor_resetChanged()
{
    editor_changed = false;
    d = document.getElementById( "id_changed" );
    d.innerHTML = "<i>Un-changed.</i>";
}

function mode_setter()
{
    d = document.getElementById( "mode" );
    mode_name = d.value;
    //alert( "mode_setter( " + mode_name + " )" );
    var mode_path = "ace/mode/" + mode_name;
    var the_mode = require( mode_path ).Mode;
    editor.getSession().setMode( new the_mode() );
}


var xmlhttp;
function getFileRequest( filename )
{
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET",filename,true); ////// asynchronous http-get: true

    xmlhttp.onreadystatechange = function() {
            if( xmlhttp.readyState==4 && xmlhttp.status==200 )
            {
                editor.getSession().setValue( xmlhttp.responseText );
                editor_resetChanged();
                editor.getSession().on('change', editor_onChanged );
            }
        };

    xmlhttp.send();
}

</script>

</head>




<body bgcolor="#cccccc">

<table border="1" width="100%">
<tr valign="top" height="714">
<td width="724">
<div id="editor">
function hello()
{
    alert( 'This was edited externally via c9.io HA ha!' );
}
</div>
</td>
<td>

<select id="mode" size="1" OnChange="mode_setter();">
 <option value="text">Text!</option>
 <option value="html">HTML</option>
 <option value="css">CSS</option>
 <option value="php">PHP</option>
 <option value="json">JSON</option>
 <option value="javascript">JavaScript</option>
</select> <span id="id_changed"><i>Un-changed.</i></span>

<?php
//================================= show the CWD
$strCwd = getcwd() . "/";
echo "<code>";
echo $strCwd;
echo "</code>\n<br>\n";


//==== show the contents
if( $dh = opendir( $strCwd ) )
{
    while( ($file = readdir($dh)) !== false )
    {
        if( filetype($strCwd  . $file) == "dir" )
        {
            echo "<b> ";
            echo "[<code class=\"st_dir\"> $file </code>]";
            echo "</b>";
        }
        else
        {
            echo "<span onmouseup=\"getFileRequest('";
            echo $file;
            echo "');\">";
            echo "<code class=\"st_file\"> $file </code>";
            echo "</span>";
            
        }
        echo "\n<br>\n";
    }
    closedir ( $dh );
}
echo "\n</code>";


//=============================== flush the buffer
flush();
?>




</td>
</tr>
</table>




</body>

</html>
