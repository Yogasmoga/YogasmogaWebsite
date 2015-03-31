

        $(document).ready(function(){
            $(".smogi-content .author-link").click(function(e){
                e.preventDefault();
                $(".close-popup").click();
                var link = $(this).attr("href");
                $(".close-popup").click();
                ajax_load_pages(link);
            });
            $(".about-rangoli a").click(function(e){
                e.preventDefault();
                $(".close-menu-btn").click();
                $(".close-popup").click();
                var link = $(this).attr("href");
                ajax_load_pages(link);
            });

            $(document).find(".ajax-load").click(function(e){
                e.preventDefault();
                //alert();
                $(".close-menu-btn").click();
                $(".close-popup").click();
                var link = $(this).attr("href");
                ajax_load_pages(link);
            });

            $(".liked-ajax-load").click(function(e){
                e.preventDefault();
                $(".close-menu-btn").click();
                $(".close-popup").click();
                var link = $(this).attr("href");
                ajax_load_pages(link);
            });
            $(".back_to_parent").click(function(e){
                e.preventDefault();
                $(".close-menu-btn").click();
                $(".close-popup").click();
                var link = $(this).attr("href");
                ajax_load_pages(link);
            });
        });
