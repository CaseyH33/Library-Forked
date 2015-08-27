<?php

class Checkout
{
    private $due_date;
    private $copy_id;
    private $patron_id;
    private $checkin_status;
    private $id;

    function __construct($due_date, $copy_id, $patron_id, $checkin_status, $id=null)
    {
        $this->due_date = $due_date;
        $this->copy_id = $copy_id;
        $this->patron_id = $patron_id;
        $this->checkin_status = $checkin_status;
        $this->id = $id;
    }

    function getDueDate()
    {
        return $this->due_date;
    }

    function setDueDate($new_due_date)
    {
        $this->due_date = $new_due_date;
    }

    function getCopyId()
    {
        return $this->copy_id;
    }

    function setCopyId($new_copy_id)
    {
        $this->copy_id = $new_copy_id;
    }

    function getPatronId()
    {
        return $this->patron_id;
    }

    function setPatronId($new_patron_id)
    {
        $this->patron_id = $new_patron_id;
    }

    function getCheckinStatus()
    {
        return $this->checkin_status;
    }

    function setCheckinStatus($new_checkin_status)
    {
        $this->checkin_status = $new_checkin_status;
    }

    function getId()
    {
        return $this->id;
    }

    //Saves a new checkout and sets due date to current date plus 14 days
    function save($patron, $date=null)
    {
        if($date == null) {
            $GLOBALS['DB']->exec("INSERT INTO checkouts_t (due_date, copy_id, patron_id, checkin_status)
                            VALUES (date_add(now(), INTERVAL 14 day), {$this->getCopyId()}, {$patron->getId()}, {$this->getCheckinStatus()});");

        }
        else {
            $GLOBALS['DB']->exec("INSERT INTO checkouts_t (due_date, copy_id, patron_id, checkin_status)
                            VALUES (date_add('{$date}', INTERVAL 14 day), {$this->getCopyId()}, {$patron->getId()}, {$this->getCheckinStatus()});");
        }

        $this->id=$GLOBALS['DB']->lastInsertId();
        $due_date_query = $GLOBALS['DB']->query("SELECT due_date FROM checkouts_t WHERE id = {$this->getId()};");

            foreach($due_date_query as $tdd){

                $my_due_date = $tdd['due_date'];
                $this->setDueDate($my_due_date);
            }
        // $this->setDueDate($due_date_query[0]['due_date']);
    }

    //Function to mark a copy as checked in. Updates checkin_status to true and due_date to null
    function checkIn()
    {
        $GLOBALS['DB']->exec("UPDATE checkouts_t SET due_date = null, checkin_status = 1 WHERE id = {$this->getId()};");
        $this->setDueDate(null);
        $this->setCheckinStatus(1);
    }

    static function getAll()
    {
        $returned_checkouts = $GLOBALS['DB']->query("SELECT * FROM checkouts_t;");
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

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM checkouts_t;");
    }


}

?>
