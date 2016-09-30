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

        function test_getAll()
        {
            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();
            $name2 = 'Foot Locker';
            $test_store2 = new Store($name2);
            $test_store2->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_deleteAll()
        {
            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();
            $name2 = 'Foot Locker';
            $test_store2 = new Store($name2);
            $test_store2->save();

            Store::deleteAll();
            $result = Store::getAll();

            $this->assertEquals([], $result);
        }

        function test_delete()
        {
            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();
            $name2 = 'Foot Locker';
            $test_store2 = new Store($name2);
            $test_store2->save();

            $test_store->delete();
            $result = Store::getAll();

            $this->assertEquals([$test_store2], $result);
        }

        function test_find()
        {
            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();
            $name2 = 'Foot Locker';
            $test_store2 = new Store($name2);
            $test_store2->save();

            $result = Store::find($test_store->getId());

            $this->assertEquals($test_store, $result);
        }
    }
?>
