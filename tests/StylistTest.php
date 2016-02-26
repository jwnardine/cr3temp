<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";
    // require_once "src/Client.php";


    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);



    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Sandra Styles";
            $test_stylist = new Stylist($name);

            //Act
            $result = $test_stylist->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Sandra Styles";
            $id = 1;
            $test_stylist = new Stylist($name, $id);

            //Act
            $result = $test_stylist->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        //function update()?

        //function delete()?

        function test_save()
        {
            //Arrange
            $name = "Michael Styles";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Sandra Styles";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $name2 = "Michael Styles";
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "Sandra Styles";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $new_name = "Sandy Styles";

            //Act
            $test_stylist->update($new_name);

            //Assert
            $this->assertEquals("Sandy Styles", $test_stylist->getName());

        }

        function test_getClients()
        {
            //Arrange
            $name = "Sandra Styles";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $stylist_id = $test_stylist->getId();

            $client_name = "Bill Client";
            $test_client = new Client($client_name, $id, $stylist_id);
            $test_client->save();

            $client_name2 = "Alice Client";
            $test_client2 = new Client($client_name2, $id, $stylist_id);
            $test_client2->save();

            //Act
            $result = $test_stylist->getClients();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_delete()
        {
         //Arrange
         $name = "Sandra Styles";
         $id = null;
         $test_stylist = new Stylist($name, $id);
         $test_stylist->save();

         $name2 = "Michael Styles";
         $test_stylist2 = new Stylist($name2, $id);
         $test_stylist2->save();


         //Act
         $test_stylist->delete();

         //Assert
         $this->assertEquals([$test_stylist2], Stylist::getAll());
        }

        function testDeleteStylist()
    {
        //Arrange
        $name = "Michael Styles";
        $id = null;
        $test_stylist = new Stylist($name, $id);
        $test_stylist->save();

        $client_name = "Alice Client";
        $stylist_id = $test_stylist->getId();
        $test_client = new Client($client_name, $id, $stylist_id);
        $test_client->save();


        //Act
        $test_stylist->delete();

        //Assert
        $this->assertEquals([], Client::getAll());
    }

        function test_deleteAll()
        {
            //Arrange
            $name = "Michael Styles";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            //Act
            Stylist::deleteAll();
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Sandra Styles";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $name2 = "Michael Styles";
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            //Act
            $result = Stylist::find($test_stylist2->getId());

            //Assert
            $this->assertEquals($test_stylist2, $result);

        }

        // function test_getClients()
        // {
        //
        // }

    }
 ?>
