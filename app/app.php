<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Stylist.php";

    // session_start();

    $app['debug'] = true;

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig',
        array(
            'stylists' => Stylist::getAll()
        ));
    });

    $app->get("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig', array(
            'stylist' => $stylist,
            'clients' => $stylist->getClients()
        ));
    });

    $app->post("/clients", function() use ($app) {
        $client_name = $_POST['rest_name'];
        $stylist_id = $_POST['stylist_id'];
        $new_client = new Client($client_name, $id = null, $stylist_id);
        $new_client->save();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array(
            'stylist' => $stylist,
            'clients' => $stylist->getClients()
        ));

    });

    $app->get("/stylists/{id}/edit", function($id) use ($app) {
        $new_stylist = Stylist::find($id);
        return $app['twig']->render('stylist_edit.html.twig', array('stylist' => $new_stylist));
    });

    $app->patch("/stylists/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $stylist = Stylist::find($id);
        $stylist->update($name);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->post("/stylists", function() use ($app) {
        $new_stylist = new Stylist($_POST['name']);
        $new_stylist->save();
        return $app['twig']->render('index.html.twig', array(
            'stylists' => Stylist::getAll()
        ));
    });


    $app->delete("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->delete();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
});

    $app->get("/client/{stylist_id}/{id}/edit_form", function($stylist_id, $id) use ($app)
    {

        $current_client = Client::find($id);
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array('current_client' => $current_client, 'stylist' => $stylist, 'clients' => $stylist->getClients(), 'form' => true));
    });


    $app->patch("/clients/updated", function() use ($app) {
        $new_name = $_POST['new_name'];
		$client_to_edit = Client::find($_POST['current_clientId']);
		$client_to_edit->update($new_name);
		$stylist = Stylist::find($_POST['stylist_id']);
		return $app['twig']->render('stylist.html.twig', array('clients' => $stylist->getClients(), 'stylist' => $stylist));
	});

    $app->post("/delete_stylists", function() use ($app) {
       Stylist::deleteAll();
       return $app['twig']->render('index.html.twig');
    });


    $app->post("/delete_clients", function() use ($app) {
       Client::deleteAll();
       $stylist = Stylist::find($_POST['stylist_id']);
       return $app['twig']->render('stylist.html.twig', array(
           'stylist' => $stylist
       ));
   });



    return $app;
 ?>
