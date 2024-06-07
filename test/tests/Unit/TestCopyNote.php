<?php

namespace Tests\Unit;

use App\Models\Note;
use App\Utils\GenerateTitle;
use PHPUnit\Framework\TestCase;

class TestCopyNote extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testNoteCopy1(): void
    {
        $generator = new GenerateTitle();
        $title = 'Hello World';
        $expect_title = 'Hello World(1)';

        $numbers   = $generator->getTitleNumber($title);
        $new_title = $generator->nextTitle($numbers);

        $this->assertEquals($expect_title, $new_title);
    }

    public function testNoteCopy2(): void
    {
        $generator = new GenerateTitle();
        $title = 'Hello World(55)';
        $expect_title = 'Hello World(56)';

        $numbers   = $generator->getTitleNumber($title);
        $new_title = $generator->nextTitle($numbers);
        
        $this->assertEquals($expect_title, $new_title);
    }

    public function testNoteCopy3(): void
    {
        $generator = new GenerateTitle();
        $title = 'Hello World(99)';
        $expect_title = 'Hello World(99)(1)';

        $numbers   = $generator->getTitleNumber($title);
        $new_title = $generator->nextTitle($numbers);
        
        $this->assertEquals($expect_title, $new_title);
    }

    public function testNoteCopy4(): void
    {
        $generator = new GenerateTitle();
        $title = 'Hello World(99)(99)';
        $expect_title = 'Hello World(99)(99)(1)';

        $numbers   = $generator->getTitleNumber($title);
        $new_title = $generator->nextTitle($numbers);
        
        $this->assertEquals($expect_title, $new_title);
    }
    
}
