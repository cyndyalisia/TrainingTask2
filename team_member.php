<?php
/*
Plugin Name: Team Members
Description: This custom for looking members in this team
Version: 1.0
Author: Cyndy Alisia Lumban Gaol
Author URI: https://www.facebook.com/cindy.alisia
*/

  function create_team_members() {
      register_post_type( 'team_members',
          array(
              'labels' => array(
                  'name' => 'Team Members',
                  'singular_name' => 'Team Members',
                  'add_new' => 'Add New',
                  'add_new_item' => 'Add Team Members',
                  'edit' => 'Edit',
                  'edit_item' => 'Edit Team Member',
                  'new_item' => 'New Team Member',
                  'view' => 'View',
                  'view_item' => 'View Team Members',
                  'search_items' => 'Search Team Members',
                  'not_found' => 'No Team Members found',
                  'not_found_in_trash' => 'No Members Reviews found in Trash',
                  'parent' => 'Parent Team Members'
              ),

              'public' => true,
              'menu_position' => 15,
              'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
              'taxonomies' => array( '' ),
              'menu_icon' => plugins_url( 'images/teamIcon.png', __FILE__ ),
              'has_archive' => true
          )
      );
  }
  add_action( 'init', 'create_team_members' );

  add_filter( 'rwmb_meta_boxes', 'your_prefix_meta_boxes' );

  function your_prefix_meta_boxes( $meta_boxes ) {
      $meta_boxes[] = array(
          'id'         => 'standard',
          'title'      =>  esc_html__( 'Other Information', 'textdomain' ),
          'context'    => 'normal',
          'post_types' => 'team_members',
          'priority'   => 'high',
          'fields'     => array(
              array(
                  'id'   => 'position',
                  'name' => esc_html__( 'Position', 'textdomain' ),
                  'type' => 'text',
              ),
              array(
                  'id' => 'email',
                  'name' => esc_html__( 'Email', 'textdomain'),
                  'type' => 'email',
                  'std' => '-',
              ),
              array(
                  'id' => 'phone_number',
                  'name' => esc_html__( 'Phone', 'textdomain'),
                  'type' => 'text',
              ),
              array(
                  'id' => 'website',
                  'name' => esc_html__( 'Website', 'textdomain'),
                  'type' => 'text',
              ),
              array(
                  'id'  => 'image',
		  'name'  => esc_html__( 'Image Upload', 'textdomain' ),
	          'type' => 'image_upload',
	          'force_delete'     => false,
	          'max_file_uploads' => 1,
		  'max_status'       => true,
              ),

            ));
        return $meta_boxes;
    }

  function show_team_member(){
  ?>
      <table>
          <tr>
              <th>Team Member</th>
          </tr>
          <?php
          //global $wpdb;
          $connectedtab = new WP_Query( array(
              'post_type' => 'team_members',
          ));

          while ( $connectedtab->have_posts() ) : $connectedtab->the_post();
          ?>
              <tr>
                  <td><?php echo the_title(); ?>
              </tr>
          <?php endwhile; ?>
      </table>
  <?php
  }

  add_shortcode('show', 'show_team_member');

  function show_member_information(){
      $connectedtab = new WP_Query( array(
          'post_type' => 'team_members',
      ));

      while ( $connectedtab->have_posts() ) : $connectedtab->the_post();
      ?>

      <table class="member_data">
        <tr style="padding-right: 120px;">
            <td>
                <?php while ( $connectedtab->have_posts()) : $connectedtab->the_post(); ?>
                      <?php echo the_title(); ?>
                <?php endwhile ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php while ( $connectedtab->have_posts()) : $connectedtab->the_post(); ?>
                    <?php
                        $upload = wp_get_attachment_image( get_post_meta( get_the_ID(), 'imgadv', 1 ), 'thumbnail' );
                        echo $upload;
                    endwhile
                  ?>
            </td>
          </tr>
          <tr>
            <td>
                <?php while ( $connectedtab->have_posts()) : $connectedtab->the_post(); ?>
                    <?php if(get_post_meta( get_the_ID(), 'email', true)!= NULL){
                        echo esc_html( get_post_meta( get_the_ID(), 'email', true ) );
                    }
                    else{
                        echo "Have no Email";
                    }
                    endwhile
                  ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php while ( $connectedtab->have_posts()) : $connectedtab->the_post(); ?>
                    <?php if (get_post_meta( get_the_ID(), 'phone_number', true ) != NULL ){
                        echo esc_html(get_post_meta( get_the_ID(), 'phone_number', true ));
                    }
                    else{
                        echo "Have no phone number";
                    }
                    endwhile
                  ?>
              </td>
            </tr>
            <tr>
              <td>
                <?php while ( $connectedtab->have_posts()) : $connectedtab->the_post(); ?>
                    <?php if(get_post_meta( get_the_ID(), 'website', true) != NULL){
                        echo esc_html( get_post_meta( get_the_ID(), 'website', true));
                    }
                    else{
                        echo "Have no Website";
                    }
                    endwhile
                  ?>
            </td>
          </tr>
      </table>
    <?php
    endwhile;
  }
  
  add_shortcode('member_information', 'show_member_information');
?>
