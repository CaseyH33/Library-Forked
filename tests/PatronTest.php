<?php


    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Patron.php";
    require_once "src/Checkout.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
            Checkout::deleteAll();
        }

        function testGetName()
        {
            $patron_name = "Randy Mclure";
            $test_patron = new Patron($patron_name);

            $result = $test_patron->getPatronName();

            $this->assertEquals($patron_name, $result);
        }

        function testGetId()
        {
            $patron_name = "Randy Mclure";
            $test_patron = new Book($patron_name);

            $result = $test_patron->getId();

            $this->assertEquals(null, $result);
        }

        function testGetAll()
        {
            $patron_name = "Randy Mclure";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $patron_name2 = "Ballface Majure";
            $test_patron2 = new Patron($patron_name2);
            $test_patron2->save();

            $result = Patron::getAll();

            $this->assertEquals([$test_patron2, $test_patron], $result);
        }

        function testSave()
        {
            $patron_name = "Randy Mclure";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $result = Patron::getAll();

            $this->assertEquals($test_patron, $result[0]);
        }

        function testFind()
        {
            $patron_name = "Randy Mclure";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $patron_name2 = "Ballface Majure";
            $test_patron2 = new Patron($patron_name2);
            $test_patron2->save();

            $result = Patron::find($test_patron->getId());

            $this->assertEquals($result,$test_patron);
        }

        function testUpdate()
        {
            $patron_name = "Randy Mclure";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $new_name = "Neal Stephenson";
            $test_patron->update($new_name);

            $this->assertEquals($new_name,$test_patron->getPatronName());
        }

        function testDelete()
        {
            $patron_name = "Randy Mclure";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $patron_name2 = "Ballface Majure";
            $test_patron2 = new Patron($patron_name2);
            $test_patron2->save();

            $test_patron->delete();

            $this->assertEquals([$test_patron2], Patron::getAll());
        }

        function testGetCheckoutHistory()
        {
            //Need to add after building checkout
        }

        function testGetCurrentCheckouts()
        {
            //Need to add after building checkout
        }

    }


    ?>
