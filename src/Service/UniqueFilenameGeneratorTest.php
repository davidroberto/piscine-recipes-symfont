<?php

namespace App\Service;

use PHPUnit\Framework\TestCase;

class UniqueFilenameGeneratorTest extends TestCase
{

    public function testGenerateUniqueFilename() {

        $uniqueFilenameGenerator = new UniqueFilenameGenerator();
        $uniqueFilename = $uniqueFilenameGenerator->generateUniqueFileName('hello', 'jpeg');

        $this->assertStringContainsString('jpeg', $uniqueFilename);
        $this->assertStringContainsString('image', $uniqueFilename);
        $this->assertStringContainsString('hello', $uniqueFilename);
    }

}