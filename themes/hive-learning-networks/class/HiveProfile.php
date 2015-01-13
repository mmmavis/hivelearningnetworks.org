<?php


  class HiveProfile {
    public $name;
    public $mainWebsite;
    public $logoUrl;
    public $description;

    public function __construct($name, $mainWebsite, $logoUrl, $description) {
      $this->name = $name;
      $this->mainWebsite = $mainWebsite;
      $this->logoUrl = $logoUrl;
      $this->description = $description;
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



?>
