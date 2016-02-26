<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_getName()
        {
            $client_name = "Alice Client";
            $id = 1;
            $stylist_id = 1;

            $test_client = new Client($client_name, $id, $stylist_id);

            //Act
            $result = $test_client->getClientName();

            //Assert
            $this->assertEquals($client_name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Sandra Styles";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $client_name = "Alice Client";
            $stylist_id = $test_stylist->getId();
            // var_dump($stylist_id);

            $test_client = new Client($client_name, $id, $stylist_id);
            $test_client->save();

            //Act
            $result = $test_client->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getStylistId()
        {
            //Arrange
            $name = "Michael Styles";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $client_name = "Alice Client";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $id, $stylist_id);

            //Act
            $result = $test_client->getStylistId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $client_name = "Alice Client";
            $id = 1;
            $stylist_id = 1;

            $test_client = new Client($client_name, $id, $stylist_id);

            $test_client->save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals($test_client, $result[0]);
        }


        function test_getAll()
        {
            //Arrange
            $client_name = "Alice Client";
            $id = 1;
            $stylist_id = 1;

            $test_client = new Client($client_name, $id, $stylist_id);

            $test_client->save();

            $client_name2 = "Bill Client";
            $id = 2;
            $stylist_id = 1;

            $test_client2 = new Client($client_name2, $id, $stylist_id);

            $test_client2->save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_find()
        {
            //Arrange
            $client_name = "Alice Client";
            $id = 1;
            $stylist_id = 1;

            $test_client = new Client($client_name, $id, $stylist_id);

            $test_client->save();

            $client_name2 = "Bill Client";
            $id = 2;
            $stylist_id = 1;

            $test_client2 = new Client($client_name2, $id, $stylist_id);

            $test_client2->save();

            //Act
            $result = Client::find($test_client2->getId());

            //Assert
            $this->assertEquals($test_client2, $result);

        }

        function test_update()
		{
			//Arrange
			$name = "Michael Styles";
			$test_stylist = new Stylist($name);
			$test_stylist->save();
			$client_name = "Bill Client";
			$stylist_id =  $test_stylist->getId();
      $id = 1;
			$test_client = new Client($client_name, $id, $stylist_id);
			$test_client->save();
			$new_name = "Billy Bob Client";
			//Act
			$test_client->update($new_name);
			//Assert
			$this->assertEquals('Billy Bob Client', $test_client->getClientName());
		}




    }

?>
