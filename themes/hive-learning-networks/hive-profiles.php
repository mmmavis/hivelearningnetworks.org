<?php
  $field_group_ID = 140;
  $fields = apply_filters('acf/field_group/get_fields', array(), $field_group_ID);
  $allProfiles = array();

  if( $fields ) {
    $numAllFields = count($fields);
    $count = 0;

    $currentProfile;
    foreach( $fields as $field ) {
      $count++;

      $field_type = $field['type'];
      $field_name = $field['name'];
      $field_label = $field['label'];
      // echo '<br/> $field_label = ' . $field_label . ' <br/>';

      if ( $field_type === 'tab' ) {
        if ( !empty($currentProfile) ) {
          // push profile to $allProfiles array
          array_push($allProfiles, $currentProfile);
        }
        // create new profile
        $currentProfile = new HiveProfile;
        $currentProfile->setProperty('name', $field_label);
      }

      if ( explode("_", $field_name)[0] === 'website' ) {
        echo '==' . get_field($field_name);
        $currentProfile->setProperty('mainWebsite', get_field($field_name));
      }

      if ( explode("_", $field_name)[0] === 'logo' ) {
        $currentProfile->setProperty('logoUrl', wp_make_link_relative(get_field($field_name)));
      }

      if ( explode("_", $field_name)[0] === 'description' ) {
        $currentProfile->setProperty('description', get_field($field_name));
      }

      if ( explode("_", $field_name)[0] === 'links' ) {
        $currentProfile->setProperty('links', get_field($field_name));
      }

      // last field in this Field Group, also the last field of the last Hive Profile
      if ( $count === $numAllFields ) {
        // push the last profile to $allProfiles array
        array_push($allProfiles, $currentProfile);
      }

    }

    echo '<br/>============== $allProfiles number ===== ' . count($allProfiles);

    foreach( $allProfiles as $profile ) {
      add_profile_to_page($profile);
    }
  }


  function add_profile_to_page($profile) {
    $name = $profile->getProperty("name");
    $mainWebsite = $profile->getProperty("mainWebsite");
    $logoUrl = $profile->getProperty("logoUrl");
    $description = $profile->getProperty("description");
    $links = $profile->getProperty("links");
    echo
      '<div class="container">' .
        '<div class="hive-profile" data-profile="' . $name . '">' .
          '<div class="row">' .
            '<div class="col-md-12">' .
              '<h3 class="the-hive-name">' . $name . '</h3>' .
            '</div>' .
          '</div>' .
          '<div class="row">' .
            '<!-- left half =========================== -->' .
            '<div class="col-md-8">' .
              '<div class="row">' .
                '<div class="col-md-6">' .
                  '<div class="hive-logo">' .
                    '<a href="' . $mainWebsite . '">' .
                      '<img src="' . $logoUrl . '" />' .
                    '</a>' .
                  '</div>' .
                '</div>' .
                '<div class="col-md-6">' .
                  '<ul class="no-bullet related-sites">' . $links . '</ul>' .
                '</div>' .
              '</div>' .
              '<div class="row hive-description">' .
                '<div class="col-md-12">' . $description . '</div>' .
              '</div>' .
            '</div>' .
            '<!-- right half (contacts) =========================== -->' .
            '<div class="col-md-4">' .

            '</div>' .
          '</div>' .
        '</div>' .
      '</div>';
  }


?>
