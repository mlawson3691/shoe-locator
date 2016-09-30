<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Store.php';
    require_once 'src/Brand.php';

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
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

        function test_update()
        {
            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();
            $new_name = 'Foot Locker';

            $test_store->update($new_name);
            $result = $test_store->getName();

            $this->assertEquals($new_name, $result);
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

        function test_addBrand()
        {
            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();

            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();

            $test_store->addBrand($test_brand->getId());
            $result = $test_store->getBrands();

            $this->assertEquals([$test_brand], $result);
        }

        function test_addBrand_preventDuplicates()
        {
            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();

            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();
            $test_store->addBrand($test_brand->getId());
            $test_store->addBrand($test_brand->getId());

            $result = $test_store->getBrands();

            $this->assertEquals([$test_brand], $result);
        }

        function test_getBrands()
        {
            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();

            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();
            $test_store->addBrand($test_brand->getId());
            $name2 = 'Adidas';
            $test_brand2 = new Brand($name2);
            $test_brand2->save();
            $test_store->addBrand($test_brand2->getId());

            $result = $test_store->getBrands();

            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_removeBrand()
        {
            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();

            $name = 'Nike';
            $test_brand = new Brand($name);
            $test_brand->save();
            $test_store->addBrand($test_brand->getId());
            $name2 = 'Adidas';
            $test_brand2 = new Brand($name2);
            $test_brand2->save();
            $test_store->addBrand($test_brand2->getId());

            $test_store->removeBrand($test_brand->getId());
            $result = $test_store->getBrands();

            $this->assertEquals([$test_brand2], $result);
        }

        function test_search()
        {
            $name = 'DSW';
            $test_store = new Store($name);
            $test_store->save();
            $name2 = 'Foot Locker';
            $test_store2 = new Store($name2);
            $test_store2->save();
            $name3 = 'Right Foot Shoes';
            $test_store3 = new Store($name3);
            $test_store3->save();

            $search_input = 'foot';
            $result = Store::search($search_input);

            $this->assertEquals([$test_store2, $test_store3], $result);
        }
    }
?>
