(function($){    
    $(function(){
        $("#header .block-search .search-icon").click(toggleMenu);
    });
    
    function toggleMenu()
    {	
		$(".block-search").toggleClass("open-search");
        return false;
    }
})(jQuery);