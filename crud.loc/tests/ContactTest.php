<?php

namespace App\Tests;
namespace App\Entity;

use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testContactCreate()
    {
        $contact = new Contact();
        $contact->setFirstName("Jane");
        $contact->setLastName("Doe");
        $contact->setPhone("+012 (34) 567-89-10");

        $this->assertEquals("Jane", $contact->getFirstName());
        $this->assertEquals("Doe", $contact->getLastName());
        $this->assertEquals("+012 (34) 567-89-10", $contact->getPhone());
    }
}
