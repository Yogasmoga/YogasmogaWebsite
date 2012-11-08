jQuery(function() {
				jQuery("#carousel ").rcarousel({
					visible: 1,
					step: 1
				});
				
				jQuery("#ui-carousel-next")
					.add("#ui-carousel-prev")
					.hover(
						function() {
							jQuery(this).css( "opacity", 0.7 );
						},
						function() {
							jQuery(this).css( "opacity", 1.0 );
						}
					);					
			});