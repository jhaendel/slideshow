<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="slides-wrapper" id="slides-wrapper-<?=$bID?>">
	<div class="slides main owl-carousel">
		<?php
			foreach( $images as $i ) {
				$f = File::getByID($i['fID']);
				$fp = new Permissions($f);
				
				if ( $fp->canViewFile() ) {
					$controller->outputSlideshowThumb($f,550,332,true,false,"slide");
				}
			}
		?>
	</div>
	<div class="slides thumbs owl-carousel">
		<?php
			foreach( $images as $i ) {
				$f = File::getByID($i['fID']);
				$fp = new Permissions($f);
				
				if ( $fp->canViewFile() ) {
					$controller->outputSlideshowThumb($f,102,62,true,false,"thumb");
				}
			}
		?>
	</div>
</div>
<script>
$(document).ready( function() {
  var slidesWrapper = $("#slides-wrapper-<?php echo $bID; ?>");
	var sync1 = slidesWrapper.children(".main");
	var sync2 = slidesWrapper.children(".thumbs");

	sync1.owlCarousel({
		//lazyLoad : true,
		//itemsScaleUp : true,
		singleItem : true,
		slideSpeed : 1000,
		navigation : true,
		navigationText : false,
		pagination: false,
		afterAction : syncPosition,
		responsiveRefreshRate : 200,
	});

	sync2.owlCarousel({
		/* items : 15,
		itemsDesktop      : [1199,10],
		itemsDesktopSmall     : [979,10],
		itemsTablet       : [768,8],
		itemsMobile       : [479,4], */
		//lazyLoad : true,
		//itemsScaleUp : true,
		mouseDrag: false,
		navigation: false,
		pagination: false,
		responsiveRefreshRate : 100,
		afterInit : function(el){
			el.find(".owl-item").eq(0).addClass("synced");
		}
	});

	function syncPosition(el){
		var current = this.currentItem;
		sync2
			.find(".owl-item")
			.removeClass("synced")
			.eq(current)
			.addClass("synced")
		if(sync2.data("owlCarousel") !== undefined){
			center(current)
		}
	}

	sync2.on("click", ".owl-item", function(e){
		e.preventDefault();
		var number = $(this).data("owlItem");
		sync1.trigger("owl.goTo",number);
	});

	function center(number){
		var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
		var num = number;
		var found = false;
		for(var i in sync2visible){
			if(num === sync2visible[i]){
				var found = true;
			}
		}

		if(found===false){
			if(num>sync2visible[sync2visible.length-1]){
				sync2.trigger("owl.goTo", num - sync2visible.length+2)
			}else{
				if(num - 1 === -1){
					num = 0;
				}
				sync2.trigger("owl.goTo", num);
			}
		} else if(num === sync2visible[sync2visible.length-1]){
			sync2.trigger("owl.goTo", sync2visible[1])
		} else if(num === sync2visible[0]){
			sync2.trigger("owl.goTo", num-1)
		}
		
	}
});
</script>