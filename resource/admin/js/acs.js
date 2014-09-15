

/**
  * script for language section 
  * TYPE OF PREFFERED LANGUAGE [$prefLaguage] CAN BE ['en{ENGLISH}'/'ar{ARABIC}']
  * cookie value [seu_lang] can be used to check cookie
  **/
   var $languageOperation = function(operation,$prefLaguage){
	   switch(operation){
	       case 'get':
	        return $.cookie("seu_lang");
	        break;
	       case 'set': 
	            $.cookie("seu_lang",$prefLaguage,{path : '/'});
	       break;
	   }
 }

 var $setLangOption = function(){
      $prefLaguage = $languageOperation('get');
     $('#opt_languages').find('a').each(function(){
         if($(this).attr('data-value')=='english' && $prefLaguage =='en'){
             $(this).children('i').addClass('icon-ok');
         } 
         if($(this).attr('data-value')=='arabic' && $prefLaguage =='ar'){
             $(this).children('i').addClass('icon-ok');
         } 
     });
 }
$(document).ready(function(){
   $prefLaguage = $languageOperation('get');
   if($prefLaguage ==null)
          $prefLaguage = prefLaguage;
   $languageOperation('set',$prefLaguage);
   $setLangOption();
   $('#opt_languages').find('a').click(function(){
       if($(this).attr('data-value')=='arabic'){
             $languageOperation('set','ar');
             $('#opt_languages').find('i').removeClass('icon-ok');
             $(this).children('i').addClass('icon-ok');
        }
        
        if($(this).attr('data-value')=='english'){
             $languageOperation('set','en');
             $('#opt_languages').find('i').removeClass('icon-ok');
             $(this).children('i').addClass('icon-ok');
        }
        location.reload();
   });
   
   
  
   
});

	 var blockUIOptions	=	{
							message: "<img src='resource/admin/img/ajax-loaders/ajax-loader-6.gif'>",
							css : { border:  'none', 
        							backgroundColor:'none'
								  }
							};

	function blockPage(selecter)
	{
		if(selecter=='')
			$.blockUI(blockUIOptions);
		else
			$(selecter).block(blockUIOptions);
	}

	function unBlockPage(selecter)
	{
		if(selecter=='')
			$.unblockUI();
		else
			$(selecter).unblock();
	}

