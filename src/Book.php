<?php

class Book
{

    private $title;
    private $id;

    function __construct($title, $id=null)
    {
        $this->title = $title;
        $this->id = $id;
    }

    function getTitle()
    {
        return $this->title;
    }

    function setTitle($new_title)
    {
        $this->title = $new_title;
    }

    function getId()
    {
        return $this->id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO books_t (title) VALUES ('{$this->getTitle()}');");
        $this->id=$GLOBALS['DB']->lastInsertId();
    }

    function update($new_title)
    {
        $GLOBALS['DB']->exec("UPDATE books_t SET title = '{$new_title}' WHERE id = {$this->getId()};");
        $this->setTitle($new_title);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM books_t WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM authors_books_t WHERE book_id = {$this->getId()};");
    }

    function addAuthor($author)
    {
        $GLOBALS['DB']->exec("INSERT INTO authors_books_t (author_id, book_id) VALUES ({$author->getId()}, {$this->getId()});");
    }

    function getAuthors()
    {
      $returned_authors = $GLOBALS['DB']->query("SELECT authors_t.* FROM books_t
          JOIN authors_books_t
          ON (books_t.id = authors_books_t.book_id)
          JOIN authors_t ON (authors_books_t.author_id = authors_t.id)
          WHERE books_t.id = {$this->getId()}
          ORDER BY authors_t.author_name;");

      $authors = array();
      foreach($returned_authors as $author) {
          $name = $author['author_name'];
          $id = $author['id'];
          $new_author = new Author($name, $id);
          array_push($authors, $new_author);
      }
      return $authors;
    }

    function addCopies($copies_number)
    {
        $book_id = $this->getId();
        for($i = 0; $i < $copies_number; $i++){
            $GLOBALS['DB']->exec("INSERT INTO copies_t (book_id) VALUES ({$book_id});");
        }
    }

    //get copies from copies table that corrospond to this book_id
    function getAllCopies()
    {
        $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies_t WHERE book_id = {$this->getId()};");
        $count = 0;
        foreach($returned_copies as $copy) {
            $count = $count + 1;
        }
        return $count;
    }

    function getAvailableCopies()
    {
        $returned_checkouts = $GLOBALS['DB']->query("SELECT checkouts_t.* FROM
                                books_t JOIN copies_t ON (books_t.id = copies_t.book_id)
                                JOIN checkouts_t ON (copies_t.id = checkouts_t.copy_id)
                                WHERE books_t.id = {$this->getId()} AND checkouts_t.checkin_status = 0;");

        // $returned_checkouts = $GLOBALS['DB']->query("SELECT checkouts_t.* FROM
        //                         books_t JOIN copies_t ON (books_t.id = copies_t.book_id)
        //                         JOIN checkouts_t ON (copies_t.id = checkouts_t.copy_id)
        //                         WHERE books_t.id = {$this->getId()} AND checkouts_t.checkin_status = 1;");
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

    function findBookTitle($search_title)
    {
        $returned_books = array();
        foreach(Book::getAll() as $book)
        {
            if($book->getTitle() == $search_title) {
                array_push($returned_books, $book);
            }
        }
        return $returned_books;
    }

    static function getAll()
    {
      $returned_books = $GLOBALS['DB']->query("SELECT * FROM books_t ORDER BY title;");
      $books = array();
      foreach($returned_books as $book) {
          $title = $book['title'];
          $id = $book['id'];
          $new_book = new Book($title, $id);
          array_push($books, $new_book);
      }
      return $books;
    }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM books_t;");
      $GLOBALS['DB']->exec("DELETE FROM copies_t;");
    }

    static function find($search_id)
    {
      $found = null;
      $books = Book::getAll();
      foreach($books as $book){
          $book_id = $book->getId();
          if($book_id == $search_id){
              $found = $book;
          }

      }//end foreach
      return $found;
    }
}

?>
