<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Brand.php';

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
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
    }
?>
