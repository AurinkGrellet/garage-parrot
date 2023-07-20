<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230719200000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO user (email, roles, password, firstname, lastname) VALUES (\'vincent.parrot@gmail.com\', \'[\"ROLE_ADMIN\"]\', \'\$2y\$13\$9CxX4DJuVcolucpJt0aV3u9PvEiMNOR07TcI1qLjBBs1e4HqAobGu\', \'Vincent\', \'Parrot\')');
        $this->addSql('INSERT INTO user (email, roles, password, firstname, lastname) VALUES (\'camille@gmail.com\', \'[\"ROLE_EMPLOYEE\"]\', \'\$2y\$13\$BO9Yv8kvhgVdlQo32yOJzezpZ5qhj9mhFo5cDCG4X1/I2KgQ31GAi\', \'Camille\', \'Dupont\')');
    }
}
