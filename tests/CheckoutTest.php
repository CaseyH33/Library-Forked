<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Checkout.php";
    //require_once "src/Copy.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CheckoutTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {

            Checkout::deleteAll();
        }

        function testGetDueDate()
        {
            $due_date = "2015-09-01";
            $copy_id = 1;
            $patron_id = 1;
            $checkin_status = 1;
            $test_checkout = new Checkout($due_date, $copy_id, $patron_id, $checkin_status);

            $result = $test_checkout->getDueDate();

            $this->assertEquals($due_date, $result);
        }

        function testGetCopyId()
        {
            $due_date = "2015-09-01";
            $copy_id = 1;
            $patron_id = 1;
            $checkin_status = 1;
            $test_checkout = new Checkout($due_date, $copy_id, $patron_id, $checkin_status);

            $result = $test_checkout->getCopyId();

            $this->assertEquals($copy_id, $result);
        }

        function testGetPatronId()
        {
            $due_date = "2015-09-01";
            $copy_id = 1;
            $patron_id = 1;
            $checkin_status = 1;
            $test_checkout = new Checkout($due_date, $copy_id, $patron_id, $checkin_status);

            $result = $test_checkout->getPatronId();

            $this->assertEquals($patron_id, $result);
        }

        function testGetCheckinStatus()
        {
            $due_date = "2015-09-01";
            $copy_id = 1;
            $patron_id = 1;
            $checkin_status = 1;
            $test_checkout = new Checkout($due_date, $copy_id, $patron_id, $checkin_status);

            $result = $test_checkout->getCheckinStatus();

            $this->assertEquals($checkin_status, $result);
        }

        function testGetId()
        {
            $due_date = "2015-09-01";
            $copy_id = 1;
            $patron_id = 1;
            $checkin_status = 1;
            $test_checkout = new Checkout($due_date, $copy_id, $patron_id, $checkin_status);

            $result = $test_checkout->getId();

            $this->assertEquals(null, $result);
        }

        function testGetAll()
        {

            $due_date = "2015-09-01";
            $copy_id = 1;
            $patron_id = 1;
            $checkin_status = 1;
            $test_checkout = new Checkout($due_date, $copy_id, $patron_id, $checkin_status);
            $test_checkout->save();
            //var_dump($test_checkout->save());//word to the wise -- var dumping a method writing things to a database still sabves the stuff in the database....doh!

            $due_date2 = "2015-09-02";
            $copy_id2 = 2;
            $patron_id2 = 3;
            $checkin_status2 = 0;
            $test_checkout2 = new Checkout($due_date2, $copy_id2, $patron_id2, $checkin_status2);
            $test_checkout2->save();

            $result = Checkout::getAll();

            $this->assertEquals([$test_checkout, $test_checkout2], $result);
        }

        function testSave()
        {
            $due_date = "2015-09-01";
            $copy_id = 1;
            $patron_id = 1;
            $checkin_status = 1;
            $test_checkout = new Checkout($due_date, $copy_id, $patron_id, $checkin_status);
            $test_checkout->save();

            $result = Checkout::getAll();

            $this->assertEquals($test_checkout, $result[0]);
        }

        function testCheckIn()
        {
            $due_date = "2015-09-01";
            $copy_id = 1;
            $patron_id = 1;
            $checkin_status = 1;
            $test_checkout = new Checkout($due_date, $copy_id, $patron_id, $checkin_status);
            $test_checkout->save();
            $test_checkout->checkIn();

            $result = $test_checkout->getCheckinStatus();

            $this->assertEquals(1, $result);
        }
    }

?>
