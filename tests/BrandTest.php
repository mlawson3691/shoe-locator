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
    }
?>
