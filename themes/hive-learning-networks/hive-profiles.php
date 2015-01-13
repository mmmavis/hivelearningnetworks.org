<?php
  $field_group_ID = 140;
  $fields = apply_filters('acf/field_group/get_fields', array(), $field_group_ID);
  $allProfiles = array();

  if( $fields ) {
    $numAllFields = count($fields);
    $count = 0;
    $contact1 = new HiveContact;
    $contact2 = new HiveContact;
    $contact3 = new HiveContact;

    $currentProfile;
    foreach( $fields as $field ) {
      $count++;

      $field_type = $field['type'];
      $field_name = $field['name'];
      $field_name_split = explode("_", $field_name);
      $field_label = $field['label'];
      // echo '<br/> $field_label = ' . $field_label . ' <br/>';
      // echo '$field_name = ' . $field_name . ' <br/>';
      // echo 'value = ' . get_field($field_name) . '</br></br>';

      if ( $field_type === 'tab' ) {
        if ( !empty($currentProfile) ) {
          // add contacts to profile
          $currentProfile->setProperty('contacts',array($contact1, $contact2, $contact3));
          // push profile to $allProfiles array
          array_push($allProfiles, $currentProfile);
        }
        // create new profile
        $currentProfile = new HiveProfile;
        $currentProfile->setProperty('name', $field_label);
        $contact1 = new HiveContact;
        $contact2 = new HiveContact;
        $contact3 = new HiveContact;
      }

      if ( $field_name_split[0] === 'website' ) {
        // echo '==' . get_field($field_name) . '== <br/>';
        $currentProfile->setProperty('mainWebsite', get_field($field_name));
      }

      if ( $field_name_split[0] === 'logo' ) {
        $currentProfile->setProperty('logo', wp_make_link_relative(get_field($field_name)));
      }

      if ( $field_name_split[0] === 'description' ) {
        $currentProfile->setProperty('description', get_field($field_name));
      }

      if ( $field_name_split[0] === 'links' ) {
        $currentProfile->setProperty('links', get_field($field_name));
      }

      if ( $field_name_split[0] === 'contact1' ) {
        // echo 'contact 1 === <br/>' . get_field($field_name) . '<br/><br/>';
        // the_field($field_name);
        $contact1->setProperty($field_name_split[1], get_field($field_name));
      }
      if ( $field_name_split[0] === 'contact2' ) {
        // echo 'contact 2 === <br/>' . get_field($field_name) . '<br/><br/>';
        // the_field($field_name);
        $contact2->setProperty($field_name_split[1], get_field($field_name));
      }
      if ( $field_name_split[0] === 'contact3' ) {
        // echo 'contact 3 === <br/>' . get_field($field_name) . '<br/><br/>';
        // the_field($field_name);
        $contact3->setProperty($field_name_split[1], get_field($field_name));
      }

      // last field in this Field Group, also the last field of the last Hive Profile
      if ( $count === $numAllFields ) {
        // push the last profile to $allProfiles array
        array_push($allProfiles, $currentProfile);
      }

    }

    echo '<br/> ============== $allProfiles number ============== ' . count($allProfiles) . '<br/>';

    foreach( $allProfiles as $profile ) {
      add_profile_to_page($profile);
    }
  }


  function build_contacts_html($contacts) {
    $html = '';
    $current_count = 0;
    foreach($contacts as $contact) {
      $current_count = $current_count+1;
      if ($contact->headshot && $contact->info) {
        $html .=
          '<div class="row contact-card">' .
            '<div class="col-md-4">' .
              '<div class="contact-photo"><img src="' . $contact->headshot . '" /></div>' .
            '</div>' .
            '<div class="col-md-8">' . $contact->info . '</div>' .
          '</div>';
      }
    }
    return $html;
  }

  function add_profile_to_page($profile) {
    $name = $profile->getProperty('name');
    $mainWebsite = $profile->getProperty('mainWebsite');
    $logo = $profile->getProperty('logo');
    $description = $profile->getProperty('description');
    $links = $profile->getProperty('links');
    $contacts = $profile->getProperty('contacts');
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
                      '<img src="' . $logo . '" />' .
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
              build_contacts_html($contacts) .
            '</div>' .
          '</div>' .
        '</div>' .
      '</div>';
  }


?>
