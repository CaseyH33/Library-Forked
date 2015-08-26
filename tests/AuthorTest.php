<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Author::deleteAll();
        }

        function test_author_getAuthorName()
        {
            //Arrange
            $author_name = "Whitman";
            $test_author = new Author($author_name);

            //Act
            $result = $test_author->getAuthorName();

            //Assert
            $this->assertEquals($author_name, $result);
        }

        function test_author_setAuthorName()
        {
            //Arrange
            $author_name = "Whitman";
            $test_author = new Author($author_name);

            //Act
            $test_author->setAuthorName("Walty");
            $result = $test_author->getAuthorName();

            //Assert
            $this->assertEquals("Walty", $result);
        }

        function test_author_getId()
        {
            //Arrange
            $id = 1;
            $author_name = "Whitman";
            $test_author = new Author($author_name, $id);

            //Act
            $result = $test_author->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_author_save()
        {
            //Arrange
            $id = 1;
            $author_name = "Whitman";
            $test_author = new Author($author_name, $id);

            //Act
            $test_author->save();

            //Assert
            $result = Author::getAll();
            $this->assertEquals($test_author, $result[0]);
        }
    }
?>
