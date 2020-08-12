<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200724063724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("insert user(username, api_key) values ('admin', 'b6d767d2f8ed5d21a44b0e5886680cb')");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("delete from user where  username = 'admin'");
    }
}
