<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get('/stores', function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'store' => null));
    });

    $app->post('/stores', function() use ($app) {
        $new_store = new Store($_POST['name']);
        $new_store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'store' => $new_store));
    });

    $app->get('/stores/{id}', function($id) use ($app) {
        $found_store = Store::find($id);
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'store' => $found_store));
    });

    $app->patch('/stores/{id}', function($id) use ($app) {
        $found_store = Store::find($id);
        $found_store->update($_POST['name']);
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'store' => $found_store));
    });

    $app->delete('/stores/{id}', function($id) use ($app) {
        $found_store = Store::find($id);
        $found_store->delete();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'store' => null));
    });

    $app->post('/stores/add/{id}', function($id) use ($app) {
        $found_store = Store::find($id);
        $found_store->addBrand($_POST['brand_id']);
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'store' => $found_store));
    });

    $app->delete('/stores/remove/{id}', function($id) use ($app) {
        $found_store = Store::find($id);
        $found_store->removeBrand($_POST['brand_id']);
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'store' => $found_store));
    });

    $app->get('/brands', function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'brand' => null));
    });

    $app->post('/brands', function() use ($app) {
        $new_brand = new Brand($_POST['name']);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll(), 'brand' => $new_brand));
    });

    $app->get('/brands/{id}', function($id) use ($app) {
        $found_brand = Brand::find($id);
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll(), 'brand' => $found_brand));
    });

    $app->patch('/brands/{id}', function($id) use ($app) {
        $found_brand = Brand::find($id);
        $found_brand->update($_POST['name']);
        return $app['twig']->render('brands.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'brand' => $found_brand));
    });

    $app->delete('/brands/{id}', function($id) use ($app) {
        $found_brand = Brand::find($id);
        $found_brand->delete();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'brand' => null));
    });

    $app->post('/brands/add/{id}', function($id) use ($app) {
        $found_brand = Brand::find($id);
        $found_brand->addStore($_POST['store_id']);
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll(), 'brand' => $found_brand));
    });

    $app->delete('/brands/remove/{id}', function($id) use ($app) {
        $found_brand = Brand::find($id);
        $found_brand->removeStore($_POST['store_id']);
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll(), 'brand' => $found_brand));
    });

    $app->post('/search', function() use ($app) {
        $search_by = $_POST['search_by'];
        if ($search_by == 'brand') {
            $results = Brand::search($_POST['search_input']);
            $category = 'brand';
        } else {
            $results = Store::search($_POST['search_input']);
            $category = 'store';
        }
        return $app['twig']->render('search.html.twig', array('results' => $results, 'category' => $category));
    });

    return $app;
?>
