<?php

namespace Phalcon\Test\Integration\Mvc\Model;

use IntegrationTester;
use Phalcon\Mvc\Model\AbstractModel;
use Phalcon\Test\Fixtures\Traits\DiTrait;
use Phalcon\Test\Models\AlbumORama\Albums;
use Phalcon\Test\Models\AlbumORama\Artists;
use Phalcon\Test\Models\AlbumORama\Songs;

class ModelsRelationsMagicCest
{
    use DiTrait;

    public function _before(IntegrationTester $I)
    {
        $this->setNewFactoryDefault();
    }

    public function _after(IntegrationTester $I)
    {
        $this->container['db']->close();
    }

    public function testModelsMysql(IntegrationTester $I)
    {
        $this->setDiMysql();

        $this->executeQueryRelated($I);
        $this->executeSaveRelatedBelongsTo($I);
    }

    /*public function testModelsPostgresql()
    {
        $di = $this->_getDI();

        $di->set(
            'db',
            function () {
                require 'unit-tests/config.db.php';

                return new Phalcon\Db\Adapter\Pdo\Postgresql($configPostgresql);
            },
            true
        );

        $this->_executeQueryRelated();
        $this->_executeSaveRelatedBelongsTo($connection);
    }

    public function testModelsSqlite()
    {
        $di = $this->_getDI();

        $di->set(
            'db',
            function () {
                require 'unit-tests/config.db.php';

                return new Phalcon\Db\Adapter\Pdo\Sqlite($configSqlite);
            },
            true
        );

        $this->_executeQueryRelated();
        $this->_executeSaveRelatedBelongsTo($connection);
    }*/

    private function executeQueryRelated(IntegrationTester $I)
    {
        //Belongs to
        $album = Albums::findFirst();
        $I->assertInstanceOf(Albums::class, $album);

        $artist = $album->artist;
        $I->assertInstanceOf(Artists::class, $artist);

        $albums = $artist->albums;
        $I->assertInstanceOf(\Phalcon\Mvc\Model\Resultset\Simple::class, $albums);
        $I->assertCount(2, $albums);
        $I->assertInstanceOf(Albums::class, $albums[0]);

        $songs = $album->songs;
        $I->assertInstanceOf(\Phalcon\Mvc\Model\Resultset\Simple::class, $songs);
        $I->assertCount(7, $songs);
        $I->assertInstanceOf(Songs::class, $songs[0]);

        $originalAlbum = $album->artist->albums[0];
        $I->assertEquals($originalAlbum->id, $album->id);
    }

    private function executeSaveRelatedBelongsTo(IntegrationTester $I)
    {
        $connection = $this->getService('db');
        $artist     = new Artists();

        $album         = new Albums();
        $album->artist = $artist;

        /**
         * @todo Check this
         */
//        //Due to not null fields on both models the album/artist aren't saved
//        $I->assertFalse($album->save());
//        $I->assertFalse($connection->isUnderTransaction());
//
        //The artists must no be saved
        $I->assertEquals(
            Model::DIRTY_STATE_TRANSIENT,
            $artist->getDirtyState()
        );

        /**
         * @todo Check this
         */
//        //The messages produced are generated by the artist model
//        $messages = $album->getMessages();
//        $I->assertEquals($messages[0]->getMessage(), 'name is required');
//        $I->assertInstanceOf(Artists::class, $messages[0]->getModel());

        //Fix the artist problem and try to save again
        $artist->name = 'Van She';

        //Due to not null fields on album model the whole
        $I->assertFalse(
            $album->save()
        );

        $I->assertFalse(
            $connection->isUnderTransaction()
        );

        //The artist model was saved correctly but album not
        $I->assertEquals(
            Model::DIRTY_STATE_PERSISTENT,
            $artist->getDirtyState()
        );

        $I->assertEquals(
            Model::DIRTY_STATE_TRANSIENT,
            $album->getDirtyState()
        );

        /**
         * @todo Check this
         */
//        $messages = $album->getMessages();
//        $I->assertEquals($messages[0]->getMessage(), 'name is required');
//        $I->assertNull($messages[0]->getModel());
//
        //Fix the album problem and try to save again
        $album->name = 'Idea of Happiness';

        //Saving OK
        $I->assertTrue(
            $album->save()
        );

        $I->assertFalse(
            $connection->isUnderTransaction()
        );

        //Both messages must be saved correctly
        $I->assertEquals(
            Model::DIRTY_STATE_PERSISTENT,
            $artist->getDirtyState()
        );

        $I->assertEquals(
            Model::DIRTY_STATE_PERSISTENT,
            $album->getDirtyState()
        );
    }
}