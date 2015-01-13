<?php
  $field_group_ID = 140;

  $fields = apply_filters('acf/field_group/get_fields', array(), $field_group_ID);

  if( $fields ) {
    echo count($fields);
    foreach( $fields as $field ) {
      $field_name = $field['name'];
      $field_label = $field['label'];
      // foreach ($field as $the_key => $the_value) {
        // echo $the_key;
        // echo '<br/>';
        // echo $mavis;
        // echo '<br/>====<br />';

        // if ( $the_key === 'label' ) {
        //   $value = $the_value;
        // }
      // }
      // echo '********<br/><br/><br/>';

      if ( $field_label === "Profile Starts" ) {
        echo '<div class="container">';
          echo '<div class="hive-profile" data-profile="xxx">';
      }

      if ( substr($field_name, 0, 5) === 'name_' ) {
            echo '<div class="row">';
              echo '<div class="col-md-12">';
                echo '<h3 class="the-hive-name">';
                  echo get_field($field_name);
                  // the_field($field_name);
                echo '</h3>';
              echo '</div>';
            echo '</div>';
      }

      if ( $field_label === "Profile Ends" ) {
          echo '</div>';
        echo '</div>';
      }

    }
  }

?>
