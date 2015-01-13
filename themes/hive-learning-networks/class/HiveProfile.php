<?php


  class HiveContact {
    public $headshot;
    public $info;

    public function __construct($headshot, $info) {
      $this->headshot = $headshot;
      $this->info = $info;
      // echo 'constractor';
    }

    public function setProperty($prop, $val) {
      $this->$prop = $val;
      // echo 'property = ' . $prop;
      // echo '<br/>value = ' . $this->$prop . '<br/><br/>===<br/>';
    }

    public function getProperty($prop) {
      // echo '*******' . $this->$prop . '*******<br/>';
      return $this->$prop;
    }
  }


  class HiveProfile {
    public $name;
    public $mainWebsite;
    public $logo;
    public $description;
    public $links;
    public $contacts;

    public function __construct($name, $mainWebsite, $logo, $description, $links, $contacts) {
      $this->name = $name;
      $this->mainWebsite = $mainWebsite;
      $this->logo = $logo;
      $this->description = $description;
      $this->links = $links;
      $this->contacts = $contacts;
      // echo 'constractor';
    }

    public function setProperty($prop, $val) {
      $this->$prop = $val;
      // echo 'property = ' . $prop . '<br/>';
      // echo '<br/>value = ' . $this->$prop . '<br/><br/>===<br/>';
    }

    public function getProperty($prop) {
      // echo '*******' . $this->$prop . '*******<br/>';
      return $this->$prop;
    }

  }



?>
