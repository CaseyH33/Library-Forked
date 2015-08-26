<?php

class Copy
{

    private $book_id;
    private $id;

    function __construct($book_id, $id=null)
    {
        $this->book_id = $book_id;
        $this->id = $id;
    }

    function getBookId()
    {
        return $this->book_id;
    }

    function setBookId($new_book_id)
    {
        $this->book_id = $new_book_id;
    }

    function getId()
    {
        return $this->id;
    }


}

?>
