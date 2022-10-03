<?php
/**
 * @package lb-quickbase-plugin
 *
 */

namespace Inc\API\Callbacks;

class CPTCallbacks 
{
    public function cptSectionManager()
    {
        echo 'Manage your custom post types';
    }

    public function cptSanitize($input) 
    {
        $output = get_option( 'qb_cpt_admin' );
        
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
            $output[$input['post_type']] = $input;

            return $output;
        }

        // Handle adding additional post types
        foreach ($output as $key => $value)
        {
            // Handle edit case when post_type is empty
            if (!isset($input['post_type'])) {
                $input = array_merge(array('post_type' => $_POST['post_type']), $input);
            }

            if( $input['post_type'] === $key )
            {
                $output[$key] = $input;
            } else {
                $output[$input['post_type']] = $input;
            }
        }

        return $output;
    }

    public function textField( $args )
    {
        $name = $args['label_for'];
		$option_name = $args['option_name'];
        $placeholder = $args['placeholder'];
        $value = '';
        $status = '';

        if ( isset($_POST["edit_post"]) ) 
        {
		    $input = get_option( $option_name );
            $value = $input[$_POST["edit_post"]][$name];

            if ($name == 'post_type') {
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

        if ( isset($_POST["edit_post"]) ) 
        {
		    $input = get_option( $option_name );
            $value = (isset($input[$_POST["edit_post"]][$name]) && $input[$_POST["edit_post"]][$name] ? 'checked=1': '');
        }

        echo '<div class="' . $classes . '"><input type="checkbox" name="' . $option_name . '[' . $name . ']' . '" id="' . $name . '" value="1" ' . $value . '"><label for="' . $name .'"><div></div></label></div>';
    }
}