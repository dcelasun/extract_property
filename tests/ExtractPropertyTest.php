<?php

class ExtractPropertyTest extends PHPUnit_Framework_TestCase
{
    protected $objects = array();
    protected $broken = array();
    
    protected function setUp()
    {
        $a = new stdClass();
        
        $a->id = 1;
        $a->name = "Foo";
        
        $b = new stdClass();
        
        $b->id = 2;
        $b->name = "Bar";
        
        $this->objects[] = $a;
        $this->objects[] = $b;
        
        $this->broken = array(
            array(
                1 => "Foo",
            ),
            array(
                2 => "Bar",
            ),
        );
    }
    
    public function testNameColumnFromObjects()
    {
        $expected = array("Foo", "Bar");
        $this->assertEquals($expected, extract_property($this->objects, 'name'));
    }
    
    public function testNameColumnFromObjectsWithIndex()
    {
        $expected = array(1 => "Foo", 2 => "Bar");
        $this->assertEquals($expected, extract_property($this->objects, 'name', 'id'));
    }
    
    public function testNonExistingColumn()
    {
        $expected = array();
        $this->assertEquals($expected, extract_property($this->objects, 'foo'));
    }

    public function testNonExistingColumnWithValidIndex()
    {
        $expected = array();
        $this->assertEquals($expected, extract_property($this->objects, 'foo', 'id'));
    }

    public function testNonExistingColumnWithInvalidIndex()
    {
        $expected = array();
        $this->assertEquals($expected, extract_property($this->objects, 'foo', 'id'));
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage extract_property() expects at least 2 parameters, 0 given
     */
    public function testNoInput()
    {
        extract_property();
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage extract_property() expects at least 2 parameters, 1 given
     */
    public function testMissingKey()
    {
        extract_property($this->objects);
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage extract_property() expects parameter 1 to be array, string given
     */
    public function testInvalidInputString()
    {
        extract_property("foo", "bar");
    }
    
    public function testInvalidInputArray()
    {
        $expected = array();
        
        $this->assertEquals($expected, extract_property($this->broken, "bar"));
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage extract_property(): The key should be either a string or an integer
     */
    public function testInvalidKey()
    {
        extract_property($this->objects, array());
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage extract_property(): The index should be either a string or an integer
     */
    public function testInvalidIndex()
    {
        extract_property($this->objects, 'name', array());
    }
    
    public function testObjectsWithPartiallyMissingProperty()
    {
        unset($this->objects[1]->name);
        
        $expected = array('Foo');
        
        $this->assertEquals($expected, extract_property($this->objects, "name"));
    }

    public function testObjectsWithPartiallyMissingPropertyWithIndex()
    {
        unset($this->objects[1]->name);

        $expected = array(1 => 'Foo');

        $this->assertEquals($expected, extract_property($this->objects, "name", "id"));
    }

    public function testObjectsWithPartiallyMissingIndex()
    {
        $this->objects[0]->id = 3;
        unset($this->objects[1]->id);
        
        $expected = array(3 => 'Foo', 4 => 'Bar');

        $this->assertEquals($expected, extract_property($this->objects, "name", "id"));
    }
}
