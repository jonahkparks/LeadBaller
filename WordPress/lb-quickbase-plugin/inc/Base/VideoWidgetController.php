<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\Base;

use Inc\Base\BaseController;
use Inc\API\Widgets\VideoWidget;

class VideoWidgetController extends BaseController
{
	public function register()
	{
        if ( ! $this->activated( 'video_widget' ) ) return;

		$video_widget = new VideoWidget();
		$video_widget->register();
	}
}