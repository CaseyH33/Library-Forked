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

        function test_author_getAll()
        {
            //Arrange
            $id = 1;
            $author_name = "Whitman";
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $id2 = 2;
            $author_name2 = "Twain";
            $test_author2 = new Author($author_name2, $id2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function test_author_deleteAll()
        {
            //Arrange
            $id = 1;
            $author_name = "Whitman";
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $id2 = 2;
            $author_name2 = "Twain";
            $test_author2 = new Author($author_name2, $id2);
            $test_author2->save();

            //Act
            Author::deleteAll();

            //Assert
            $result = Author::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $id = 1;
            $author_name = "Whitman";
            $test_author = new Author($author_name, $id);
            $test_author->save();

            $id2 = 2;
            $author_name2 = "Twain";
            $test_author2 = new Author($author_name, $id2);
            $test_author2->save();

            //Act
            $result = Author::find($test_author2->getId());

            //Assert
            $this->assertEquals($test_author2, $result);
        }

        

    }
?>
