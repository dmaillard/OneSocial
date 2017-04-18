<?php
/**
 * OneSocial user options/settings
 *
 * @package OneSocial
 */

 /**
 * This is the file that contains all settings custom fields & options functions for users/members
 */
 
 /**
  * Return the array of all social fields supported.
  * @since OneSocial 1.0.0
  * @return array list of social sites.
  **/
 function buddyboss_get_user_social_array() {
    
    $socials = array("facebook" => "Facebook",
                     "twitter" => "Twitter",
                     "linkedin" => "Linkedin",
                     "google-plus" => "Google+",
                     "youtube" => "Youtube",
                     "instagram" => "Instagram",
                     "pinterest" => "Pinterest");
    
    return (array) @apply_filters("buddyboss_get_user_social_array",$socials);
    
 }

/*
 * Remove disabled from socials.
 *
 * */

function buddyboss_user_social_remove_disabled( $socials ) {

	$social_profiles = onesocial_get_option( 'profile_social_media_links' );

	foreach ( $social_profiles as $key => $value ) {

		if ( $value == '0' ) {
			unset( $socials[ $key ] ); // unset fields from $socials array.
		}
	}

	if ( !onesocial_get_option( 'profile_social_media_links_switch' ) ) {
		unset( $socials );
	}

	return $socials;
}

/**
 * Check if array has any non-empty value
 * @since 1.0
 **/
function buddyboss_array_not_all_empty($array){
    foreach ($array as $value) {
        if(!empty($value)) {
            return true;
        }
    }
    return false;
}
 
/**
 * Output the fields inputs on user screen
 * @since 1.0
 **/
function buddyboss_user_social_fields( $user_id = false ) {
    global $bp;

    if( !$user_id )
		$user_id = bp_displayed_user_id();
    
    /* field will only shown on base. 
     * so if in case we are on somewhere else then skip it ! 
	 * 
	 * It's safe enough to assume that 'base' profile group will always be there and its id will be 1,
	 * since there's no apparent way of deleting this field group.
	 */
    if( !function_exists('bp_get_the_profile_group_id') || (function_exists('bp_get_the_profile_group_id') && bp_get_the_profile_group_id() != 1 && ! is_admin() )) {
        return;
    }

    $socials = (array) get_user_meta($user_id,"user_social_links",true);
	
	add_filter( "buddyboss_get_user_social_array", "buddyboss_user_social_remove_disabled" ); //remove disabled.

    //Profile > Edit > edit user's social links
	if( 'edit'== $bp->current_action ){

		?>
		<div class="buddyboss-user-social">

		<input type="hidden" name="buddyboss_user_social" value="1">    

		<?php foreach(buddyboss_get_user_social_array() as $social => $name): ?>

		<div class="bp-profile-field editfield field_type_textbox field_<?php  echo $social; ?>">
		<label for="buddyboss_<?php  echo $social; ?>"><?php echo $name; ?></label>
		<input id="buddyboss_<?php  echo $social; ?>" name="buddyboss_<?php  echo $social; ?>" type="text" value="<?php echo esc_attr(@$socials[$social]); ?>" />
		</div>

		<?php endforeach; ?>
		</div>
		<?php

    //Profile > View > display user's social links
	} else if ( 'public' == $bp->current_action ) {
        if( buddyboss_array_not_all_empty($socials)){
            ?>
            <div class="bp-widget social">
                <h4><?php _e('Social', 'onesocial');?></h4>
                <table class="profile-fields">
                    <tbody>

                    <?php foreach(buddyboss_get_user_social_array() as $social => $name): ?>

                        <?php
                        $field_value = @$socials[$social];
                        if( empty( $field_value ) )
                            continue;

                        $field_value = make_clickable( $field_value );
                        ?>
                        <tr class="field_type_textbox field_<?php  echo $social; ?>">
                            <td class="label"><?php echo $name; ?></td>
                            <td class="data"><?php echo $field_value; ?></td>
                        </tr>

                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php
        }

    //xProfile Profile admin area edit user's social links
    } else if ( is_admin() && ! empty( $bp->profile->admin ) ) {
        ?>
		<div class="bp-widget social">

            <input type="hidden" name="buddyboss_user_social" value="1">

            <?php
            foreach(buddyboss_get_user_social_array() as $social => $name): ?>

                <?php

                    $field_value = @$socials[$social];

                    //$field_value = make_clickable( $field_value );
                    ?>
                    <div<?php bp_field_css_class( 'bp-profile-field' ); ?>>
                        <label for="<?php echo $social; ?>" class="label"><?php echo $name; ?></label>
                        <input id="<?php echo $social; ?>"  name="buddyboss_<?php echo $social; ?>" type="text" value="<?php echo $field_value ?>" aria-required="true">
                    </div>
                <?php endforeach; ?>

		</div>
		<?php
	}
}

//add_action("bp_custom_profile_edit_fields","buddyboss_user_social_fields");
add_action("bp_after_profile_field_content","buddyboss_user_social_fields");


/**
 * Output the fields inputs on user screen
 * @since OneSocial 1.0.0
 **/
function buddyboss_user_social_fields_admin( $user_id = 0, $screen_id = '', $stats_metabox = null ) {
    // Set the screen ID if none was passed
	if ( empty( $screen_id ) ) {
		$screen_id = buddypress()->members->admin->user_page;
	}
	
	add_meta_box(
		'bp_xprofile_user_admin_fields_social',
		__( 'Social', 'onesocial'),
		'buddyboss_user_social_fields_metabox',
		$screen_id,
		'normal',
		'core',
		array( 'user_id' => $user_id )
	);
}
// Register the metabox in Member's community admin profile
//add_action( 'bp_members_admin_xprofile_metabox', 'buddyboss_user_social_fields_admin', 11, 3 );
add_action( 'bp_members_admin_xprofile_metabox', 'buddyboss_user_social_fields_admin', 11 );

function buddyboss_user_social_fields_metabox( $user, $param ){
	$user_id = isset( $param['args'] ) && isset( $param['args']['user_id'] ) ? $param['args']['user_id'] : false;
	buddyboss_user_social_fields( $user_id );
}

/**
 * Save the user social fields data
 * @since OneSocial 1.0.0
 **/
function buddyboss_user_social_fields_save($user_id, $posted_field_ids, $errors ) {
	
    if(empty($user_id)) { // no user ah! skip it then.
        return; 
    }
    
    $socials = get_user_meta($user_id,"user_social_links",true);
    
    if(!is_array($socials)) {
        $socials = array();
    }
    
    if($_POST["buddyboss_user_social"] == "1"){

         foreach(buddyboss_get_user_social_array() as $social => $name) {

            $url = $_POST["buddyboss_".$social];
             
            //check if its valid URL
            if(filter_var($url, FILTER_VALIDATE_URL) || empty($url) ) {
                $socials[$social] = $url;
            }
            
         }
         
         update_user_meta($user_id,"user_social_links",$socials); //update it
		 
    }
    
    
}

add_action("xprofile_updated_profile","buddyboss_user_social_fields_save",1,3);

/**
 * Return the user social data
 * @since 1.0
 * @param (int) $user_id
 * @param (int) $social  //social site slug
 * return (string) //URL format.
 **/
function buddyboss_get_user_social($user_id,$social) {
     $socials = (array) get_user_meta($user_id,"user_social_links",true);
     return (@$socials[$social]);
}