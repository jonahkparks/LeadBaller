<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\API\Widgets;

use WP_Widget;

class VideoWidget extends WP_Widget
{

    public $widget_ID;
    public $widget_name;
    public $widget_options = array();
    public $control_options = array();

    
	function __construct() {

		$this->widget_ID = 'lb_qb_video_widget';
		$this->widget_name = 'QuickBase Video Widget';

		$this->widget_options = array(
			'classname' => $this->widget_ID,
			'description' => $this->widget_name,
			'customize_selective_refresh' => true,
		);

		$this->control_options = array(
			'width' => 400,
			'height' => 350,
		);
	}

    public function register() 
    {
        parent::__construct( $this->widget_ID, $this->widget_name, $this->widget_options, $this->control_options );

		add_action( 'widgets_init', array( $this, 'widgetsInit') );
    }

    public function widgetsInit()
    {
        register_widget( $this );
    }

    public function widget( $args, $instance )
    {
        $video_url = "https://storage.googleapis.com/shakr-videos-lime/2022/08/24/eeafcfb67910c22cd1ffdcadad8a131a4e6d14986d5e4d5a3b1f55b28df006e5/9e68d6?Expires=1661787142&GoogleAccessId=storage-accessor%40shakr-infra-stag.iam.gserviceaccount.com&Signature=IIq0f93WAoCpy1HZ0ynhrF96z9u7Jg10L6yUtB4h3bokjTSUdis2ycDCklU5Fkibsa1IeiGGRU%2B3iIca1AkNzBu3PGYdSRao1hMyyRM%2F88r%2BwlLkG%2FbjdP4XQfE6JwpG%2BgwpLr7NRrDpBnaweUMoNCoXoMXQaDpAcof9bZVn3xXYv1KEmrI2%2BekeSA%2F2TvhvnjIpPjcH77GfMi0NFlubItiwrVhOYwTDPhFgraFpMeVOC1PZVCk%2FIpR%2FY%2B7Xo5dz4W1CrmjAt8mfbTw5HZEynQd7d8JzWzoPb%2Bdg00HbyQMHnV%2Bk928BQBRJYWPmMiCLRt530mG1QGthvlHcwPXwcw%3D%3D";

        echo $args['before_widget'];
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

        if (!empty( $instance['image'] ))
        {
            echo '<video width="500" controls>';
            echo '<source src="'. $video_url . '" type="video/mp4">';
            echo '</video>';
        }
		echo $args['after_widget'];
    }

    public function form( $instance )
    {
        $title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Custom Text', 'awps' );
        $titleID = esc_attr( $this->get_field_id( 'title' ));
        $titleName = esc_attr( $this->get_field_name( 'title' ));

        $image = !empty( $instance['image'] ) ? $instance['image'] : '';
        $imageID = esc_attr( $this->get_field_id( 'image' ));
        $imageName = esc_attr( $this-> get_field_name( 'image' ));

		?>
		<p>
		<label for="<?php echo $titleID; ?>"><?php esc_attr_e( 'Title:', 'awps' ); ?></label> 
		<input class="widefat" id="<?php echo $titleID; ?>" name="<?php echo $titleName; ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
		<label for="<?php echo $imageID; ?>"><?php esc_attr_e( 'Image:', 'awps' ); ?></label> 
		<input class="widefat image-upload" id="<?php echo $imageID; ?>" name="<?php echo $imageName; ?>" type="text" value="<?php echo esc_url( $image ); ?>">
        <button type="button" class="button button-primary js-image-upload">Select Image</button>
		</p>
		<?php 
    }

    public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['image'] = !empty( $new_instance['image'] ) ? $new_instance['image'] : '';

		return $instance;
    }
}