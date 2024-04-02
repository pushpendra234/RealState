    jQuery('.same-height').each(function(){  
      var highestBox = 0;
      
    
      jQuery('.column', this).each(function(){
        
        // If this box is higher than the cached highest then store it
        if(jQuery(this).height() > highestBox) {
          highestBox = jQuery(this).height(); 
        }
      
      });  
            
      // Set the height of all those children to whichever was highest 
      jQuery('.column',this).height(highestBox);
                    
    }); 



jQuery(document).ready(function(){ 
    jQuery('.mobile-icon').click(function(){ 
        jQuery('.navs ul').slideToggle();
    
});
    
    });
