<?php
defined('C5_EXECUTE') or die("Access Denied.");
class SlideshowBlockController extends Concrete5_Controller_Block_Slideshow {
	public function outputSlideshowThumb($obj, $maxWidth, $maxHeight, $crop = false, $lazyload = true, $wrapperClass = null) {
		$ih = Loader::helper("image");
		$thumb = $ih->getThumbnail($obj, $maxWidth, $maxHeight, $crop);
		$alt = $obj->getTitle();
		
		//$html = '<div class="' . $wrapperClass . '" style="width:' . $thumb->width . 'px; height:' . $thumb->height . 'px">';
		$html = '<div class="' . $wrapperClass . '" style="width:' . $thumb->width . 'px; height:' . $thumb->height . 'px">';
		if ( $lazyload ) {
			$html .= '<img class="lazyOwl" alt="' . $alt . '" data-src="' . $thumb->src . '" width="' . $thumb->width . '" height="' . $thumb->height . '" />';
		} else {
			$html .= '<img alt="' . $alt . '" src="' . $thumb->src . '" width="' . $thumb->width . '" height="' . $thumb->height . '" />';
		}
		$html .= '</div>';
		
		if ($return) {
			return $html;
		} else {
			print $html;
		}
	}
}