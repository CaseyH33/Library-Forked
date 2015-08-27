<?php

class Patron
{

    private $patron_name;
    private $id;

    function __construct($patron_name, $id=null)
    {
        $this->patron_name = $patron_name;
        $this->id = $id;
    }

    function getPatronName()
    {
        return $this->patron_name;
    }

    function setPatronName($new_patron_name)
    {
        $this->patron_name = $new_patron_name;
    }

    function getId()
    {
        return $this->id;
    }


    function save()
      {
          $GLOBALS['DB']->exec("INSERT INTO patrons_t (patron_name) VALUES ('{$this->getPatronName()}');");
          $this->id=$GLOBALS['DB']->lastInsertId();
      }

      function update($new_name)
      {
          $GLOBALS['DB']->exec("UPDATE patrons_t SET patron_name = '{$new_name}' WHERE id = {$this->getId()};");
          $this->patron_name = $new_name;
      }

      function delete()
      {
          $GLOBALS['DB']->exec("DELETE FROM patrons_t WHERE id = {$this->getId()};");
      }

      function getCheckoutHistory()
      {
          $returned_checkouts = $GLOBALS['DB']->query("SELECT * FROM checkouts_t WHERE patron_id = {$this->getId()}; ORDER BY due_date");
          $checkouts = array();
          foreach($returned_checkouts as $checkout) {
              $due_date = $checkout['due_date'];
              $copy_id = $checkout['copy_id'];
              $patron_id = $checkout['patron_id'];
              $checkin_status = $checkout['checkin_status'];
              $id = $checkout['id'];
              $new_checkout = new Checkout($due_date, $copy_id, $patron_id, $checkin_status, $id);
              array_push($checkouts, $new_checkout);
          }
          return $checkouts;
      }

      function getCurrentCheckouts()
      {
          //Will list all books currently checked out by this patron
          //Need to add after building checkout
      }

      static function getAll()
      {
          $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons_t ORDER BY patron_name;");
          $patrons = array();
          foreach($returned_patrons as $patron) {
              $patron_name = $patron['patron_name'];
              $id = $patron['id'];
              $new_book = new Patron($patron_name, $id);
              array_push($patrons, $new_book);
          }
          return $patrons;
      }

      static function deleteAll()
      {
          $GLOBALS['DB']->exec("DELETE FROM patrons_t;");
      }

      static function find($search_id)
      {
          $found = null;
          $patrons = Patron::getAll();
          foreach($patrons as $patron){
              $patron_id = $patron->getId();
              if($patron_id == $search_id){
                  $found = $patron;
              }

          }//end foreach
          return $found;
      }




}

?>
