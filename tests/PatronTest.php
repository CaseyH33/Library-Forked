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
            $patron_name = "Randy Mclure";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $due_date = "2013-09-05";
            $copy_id = 1;
            $patron_id = 1;
            $checkin_status = 1;
            $test_checkout = new Checkout($due_date, $copy_id, $test_patron->getId(), $checkin_status);
            $test_checkout->save($test_patron, $due_date);

            $due_date2 = "2015-09-10";
            $copy_id2 = 2;
            $patron_id2 = 3;
            $checkin_status2 = 0;
            $test_checkout2 = new Checkout($due_date2, $copy_id2, $test_patron->getId(), $checkin_status2);
            $test_checkout2->save($test_patron);

            $this->assertEquals([$test_checkout, $test_checkout2], $test_patron->getCheckoutHistory());
        }

        function testGetCurrentCheckouts()
        {
            $patron_name = "Randy Mclure";
            $test_patron = new Patron($patron_name);
            $test_patron->save();

            $due_date = null;
            $copy_id = 1;
            $checkin_status = 1;
            $test_checkout = new Checkout($due_date, $copy_id, $test_patron->getId(), $checkin_status);
            $test_checkout->save($test_patron, $due_date);
            $test_checkout->checkIn();

            $due_date2 = null;
            $copy_id2 = 2;
            $checkin_status2 = 0;
            $test_checkout2 = new Checkout($due_date2, $copy_id2, $test_patron->getId(), $checkin_status2);
            $test_checkout2->save($test_patron);

            $result = $test_patron->getCurrentCheckouts();

            $this->assertEquals([$test_checkout2], $result);
        }

    }


    ?>
