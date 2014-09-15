<?php 
/***
File Name: basic_text_template.php
Created By: ACS Dev
Created On: July 28, 2014
Purpose: to get various text template
*/
function text_template($key)
{
    $template_ = array(
	    'file_info' => "\nFile Name: %s \nCreated By: %s \nCreated On: %s \nPurpose: %s \n",
	    'include_javascript' => "<script type=\"text/javascript\" src=\"%s\"></script>",
	    'include_css' => "<link rel=\"stylesheet\" type=\"text/css\" href=\"%s\">",
	    'text' => "<div class=\"col-md-5 %s\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"%s\"))?><span class=\"text-danger\">%s</span></label>\n\t\t\t<input class=\"form-control\" rel=\"%s\" id=\"%s\" name=\"%s\" value=\"<?php echo \$posted[\"%s\"];?>\" type=\"text\" /><span class=\"text-danger\"></span>\n\t\t</div>\n\t</div>",
        'radio' => "<div class=\"col-md-5\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"%s\"))?><span class=\"text-danger\">%s</span></label>\n\t\t\t<input type=\"radio\" name=\"%s\" id=\"%s\" value=\"<?php echo \$posted[\"%s\"]?>\">n<span class=\"text-danger\"></span>\n\t\t</div>\n</div>",
        'image_upload' => "<div class=\"col-md-5 %s\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"Upload %s\"))?><span class=\"text-danger\">%s</span></label>\n\t\t\t%s<input id=\"%s\" name=\"%s\" type=\"file\" /><span class=\"text-danger\"></span>\n\t\t</div>\n\t</div>",
        'file_upload' => "<div class=\"col-md-5 %s\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"Upload %s\"))?><span class=\"text-danger\">%s</span></label>\n\t\t\t%s<input id=\"%s\" name=\"%s\" type=\"file\" /><span class=\"text-danger\"></span>\n\t\t</div>\n\t</div>",
    );

   	return $template_[$key];
}
?>
