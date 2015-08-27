<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";
    require_once "src/Checkout.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
            Checkout::deleteAll();
            Patron::deleteAll();
        }

        function testGetTitle()
        {
            $title = "Anathem";
            $test_book = new Book($title);

            $result = $test_book->getTitle();

            $this->assertEquals($title, $result);
        }

        function testGetId()
        {
            $title = "Anathem";
            $test_book = new Book($title);

            $result = $test_book->getId();

            $this->assertEquals(null, $result);
        }

        function testGetAll()
        {
            $title = "Anathem";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Snow Crash";
            $test_book2 = new Book($title2);
            $test_book2->save();

            $result = Book::getAll();

            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function testSave()
        {
            $title = "Anathem";
            $test_book = new Book($title);
            $test_book->save();

            $result = Book::getAll();

            $this->assertEquals($test_book, $result[0]);
        }

        function testFind()
        {
            $title = "Anathem";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Snow Crash";
            $test_book2 = new Book($title2);
            $test_book2->save();

            $result = Book::find($test_book->getId());

            $this->assertEquals($result,$test_book);
        }

        function testUpdate()
        {
            $title = "Anathem";
            $test_book = new Book($title);
            $test_book->save();

            $new_title = "crypotnomicon";
            $test_book->update($new_title);

            $this->assertEquals($new_title,$test_book->getTitle());

        }

        function testDelete()
        {
            $title = "Anathem";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Snow Crash";
            $test_book2 = new Book($title2);
            $test_book2->save();

            $test_book->delete();

            $this->assertEquals([$test_book2], Book::getAll());
        }

        function testAddAuthor()
        {
            $title = "Carrie";
            $test_book = new Book($title);
            $test_book->save();

            $name = "Stephen King";
            $test_author = new Author($name);
            $test_author->save();

            $test_book->addAuthor($test_author);

            $this->assertEquals($test_book->getAuthors(), [$test_author]);
        }

        function testGetAuthors()
        {
            $title = "Carrie";
            $test_book = new Book($title);
            $test_book->save();

            $name = "Stephen King";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Joe Hill";
            $test_author2 = new Author($name2);
            $test_author2->save();

            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);

            $this->assertEquals([$test_author2, $test_author], $test_book->getAuthors());
        }

        function testAddCopies()
        {

            $title = "Carrie";
            $test_book = new Book($title);
            $test_book->save();

            $test_book->addCopies(5);
            $result = $test_book->getAllCopies();
            $this->assertEquals(5, $result);
        }

        //Test passes with adding the copy_id from the phpmyadmin data
        // function testGetAvailableCopies()
        // {
        //     $title = "Carrie";
        //     $test_book = new Book($title);
        //     $test_book->save();
        //
        //     $test_patron = new Patron("Bobby");
        //     $test_patron->save();
        //
        //     $test_book->addCopies(4);
        //
        //     $test_checkout = new Checkout(null, 133, $test_patron->getId(), 0);
        //     $test_checkout->save($test_patron);
        //
        //     $result = sizeof($test_book->getAvailableCopies());
        //     $this->assertEquals(1, $result);
        // }


    }//end class

 ?>
