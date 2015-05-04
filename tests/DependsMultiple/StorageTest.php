<?php
namespace UnitTests\DependsMultiple;

use Examples\DependsMultiple\Storage;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * isEmpty returns true when the storage is initialized and has not items
     */
    public function testIsEmptyReturnsTrueWhenTheStorageIsInitializedAndHasNotItems()
    {
        $storage = new Storage();
        $this->assertTrue($storage->isEmpty());

        return $storage;
    }

    /**
     * isEmpty returns false when after initializing the storage we add two valid keys
     */
    public function testIsEmptyReturnsFalseWhenAfterInitializingTheStorageWeAddTwoValidKeys()
    {
        $storage = new Storage();
        $storage->add(1, 'first');
        $storage->add(2, 'second');
        $this->assertFalse($storage->isEmpty());
        $this->assertCount(2, $storage->getAll());

        return $storage;
    }

    /**
     * isEmpty returns false when after initializing the storage we add three valid keys
     */
    public function testIsEmptyReturnsFalseWhenAfterInitializingTheStorageWeAddThreeValidKeys()
    {
        $storage = new Storage();
        $storage->add(3, 'first');
        $storage->add(4, 'second');
        $storage->add(5, 'third');
        $this->assertFalse($storage->isEmpty());
        $this->assertCount(3, $storage->getAll());

        return $storage;
    }

    /**
     * Merging the two existing storages produces a new storage with all keys combined.
     *
     * @param $twoKeyStorage Storage
     * @param $threeKeyStorage Storage
     * @depends testIsEmptyReturnsFalseWhenAfterInitializingTheStorageWeAddTwoValidKeys
     * @depends testIsEmptyReturnsFalseWhenAfterInitializingTheStorageWeAddThreeValidKeys
     */
    public function testMergingTheTwoExistingStoragesProducesANewStorageWithAllKeysCombined($twoKeyStorage, $threeKeyStorage)
    {
        $this->assertFalse($twoKeyStorage->isEmpty());
        $this->assertFalse($threeKeyStorage->isEmpty());

        $newStorage = $twoKeyStorage->merge($threeKeyStorage);

        $this->assertCount(5, $newStorage->getAll());
    }
}