(function($){    
    $(function(){
        $("#header .btn-menu a").click(toggleMenu);
    });
    
    function toggleMenu()
    {	
    	if($(window).width() < 1100)
    	{
			$("body").toggleClass("open-menu");
	        return false;
    	}
    }

    $(window).resize(function(){

    	if($(window).width() > 1100)
    	{
    		$("body").removeClass("open-menu");
    	}
    });
})(jQuery);