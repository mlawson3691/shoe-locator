<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Store.php';

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
        }

        function test_save()
        {
            $name = 'DSW';
            $test_store = new Store($name);

            $test_store->save();
            $result = Store::getAll();

            $this->assertEquals($test_store, $result[0]);
        }
    }
?>
