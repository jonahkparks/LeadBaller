<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\API\Callbacks;

class TableCallbacks
{

    public function tableSanitize($input) 
    {
        $output = get_option( 'qb_table_admin' );
        
        // Handle removing a single post type
        if (isset($_POST['remove']))
        {
            $remove = filter_input( INPUT_POST, 'remove', FILTER_SANITIZE_STRING, array( 'default' => false ) ); 
            unset($output[$remove]);

            return $output;
        }

        // Handle adding the first post type 
        if ( count($output) == 0 )
        {
            $output[$input['table']] = $input;

            return $output;
        }

        // Handle adding additional post types
        foreach ($output as $key => $value)
        {
            // Handle edit case when post_type is empty
            if (!isset($input['table'])) {
                $input = array_merge(array('table' => $_POST['table']), $input);
            }

            if( $input['table'] === $key )
            {
                $output[$key] = $input;
            } else {
                $output[$input['table']] = $input;
            }
        }

        return $output;
    }

    public function tableSectionManager()
    {
        echo 'Manage your tables';
    }

    public function textField( $args )
    {
        $name = $args['label_for'];
		$option_name = $args['option_name'];
        $placeholder = $args['placeholder'];
        $value = '';
        $status = '';

        if ( isset($_POST["edit_table"]) ) 
        {
		    $input = get_option( $option_name );
            $value = $input[$_POST["edit_table"]][$name];

            if ($name == 'table') {
                $status = 'disabled=1';
            }
        }

        echo '<input type="text" class="regular-text" name="' . $option_name . '[' . $name . ']' . '" id="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" ' . $status . ' required>';
    }

    public function checkboxField( $args)
    {
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];
        $value = '';

        if ( isset($_POST["edit_table"]) ) 
        {
		    $input = get_option( $option_name );
            $value = (isset($input[$_POST["edit_table"]][$name]) && $input[$_POST["edit_table"]][$name] ? 'checked=1': '');
        }

        echo '<div class="' . $classes . '"><input type="checkbox" name="' . $option_name . '[' . $name . ']' . '" id="' . $name . '" value="1" ' . $value . '"><label for="' . $name .'"><div></div></label></div>';
    }

    public function checkboxPostTypesField( $args )
    {
        $output = '';
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checked = false;

		if ( isset($_POST["edit_table"]) ) {
			$checkbox = get_option( $option_name );
		}

		$post_types = get_post_types( array( 'show_ui' => true ) );

		foreach ($post_types as $post) {

			if ( isset($_POST["edit_table"]) ) {
				$checked = isset($checkbox[$_POST["edit_table"]][$name][$post]) ?: false;
			}

			$output .= '<div class="' . $classes . ' mb-10"><input type="checkbox" id="' . $post . '" name="' . $option_name . '[' . $name . '][' . $post . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $post . '"><div></div></label> <strong>' . $post . '</strong></div>';
		}

        echo $output;
    }
}