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
