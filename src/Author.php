<?php

class Author
{

    private $author_name;
    private $id;

    function __construct($author_name, $id=NULL)
    {
        $this->author_name = $author_name;
        $this->id = $id;
    }

    function getAuthorName()
    {
        return $this->author_name;
    }

    function setAuthorName($new_author_name)
    {
        $this->author_name = $new_author_name;
    }

    function getId()
    {
        return $this->id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO authors_t (author_name) VALUES ('{$this->getAuthorName()}')");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE authors_t SET author_name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setAuthorName($new_name);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM authors_t WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM authors_books_t WHERE author_id = {$this->getId()};");
    }

    function addBook($book)
    {
        $GLOBALS['DB']->exec("INSERT INTO authors_books_t (author_id, book_id) VALUES ({$this->getId()},{$book->getId()});");
    }

    function getBooks()
    {
        $returned_books = $GLOBALS['DB']->query("SELECT books_t.* FROM authors_t JOIN authors_books_t ON (authors_t.id = authors_books_t.author_id) JOIN books_t ON (authors_books_t.book_id = books_t.id) WHERE authors_t.id = {$this->getId()} ORDER BY books_t.title;");

        $books = array();
        foreach($returned_books as $book){
            $title = $book['title'];
            $id = $book['id'];
            $new_book = new Book($title,$id);
            array_push($books, $new_book);

        }//end foreach
        return $books;
    }


    static function find($search_id)
    {
    $found_author = "";
    $authors = Author::getAll();
    foreach($authors as $author) {
        $author_id = $author->getId();
        if ($author_id == $search_id) {
            $found_author = $author;
        }
    }
    return $found_author;
    }

    static function getAll()
    {
        $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors_t;");
        $authors = array();
        foreach($returned_authors as $author) {
            $author_name = $author['author_name'];
            $id = $author['id'];
            $new_author = new Author($author_name, $id);
            array_push($authors, $new_author);
        }

        return $authors;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM authors_t;");
    }

}

 ?>
