<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Brand.php';
    require_once 'src/Store.php';

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function test_save()
        {
            $name = 'Nike';
            $test_brand = new Brand($name);

            $test_brand->save();
            $result = Brand::getAll();

            $this->assertEquals($test_brand, $result[0]);
        }

        function test_getAll()
        {
            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();
            $name2 = 'Adidas';
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            $result = Brand::getAll();

            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_deleteAll()
        {
            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();
            $name2 = 'Adidas';
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            Brand::deleteAll();
            $result = Brand::getAll();

            $this->assertEquals([], $result);
        }

        function test_find()
        {
            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();
            $name2 = 'Adidas';
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            $result = Brand::find($test_brand2->getId());

            $this->assertEquals($test_brand2, $result);
        }

        function test_addStore()
        {
            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();

            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();

            $test_brand->addStore($test_store->getId());
            $result = $test_brand->getStores();

            $this->assertEquals([$test_store], $result);
        }

        function test_getStores()
        {
            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();

            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();
            $test_brand->addStore($test_store->getId());
            $name2 = 'Foot Locker';
            $test_store2 = new Store($name2);
            $test_store2->save();
            $test_brand->addStore($test_store2->getId());

            $result = $test_brand->getStores();

            $this->assertEquals([$test_store, $test_store2], $result);
        }
    }
?>
