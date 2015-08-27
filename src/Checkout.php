<?php

class Checkout
{
    private $due_date;
    private $copy_id;
    private $patron_id;
    private $checkin_status;
    private $id;

    function __construct($due_date, $copy_id, $patron_id, $checkin_status=1, $id=null)
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

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM checkouts_t;");
    }


}

?>
