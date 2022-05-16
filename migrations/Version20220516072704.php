<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516072704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE representation_values DISABLE TRIGGER ALL;');
        $this->addSql('ALTER TABLE values DISABLE TRIGGER ALL;');
        $this->addSql('update public.representation_values set fk_characteristic=\'3aa37e2b-f198-48c1-b116-3ad90a9305d9\' where fk_characteristic=\'a9690c9a-8b00-023c-83db-f58bd6b9666c\';');
        $this->addSql("UPDATE values set fk_char='3aa37e2b-f198-48c1-b116-3ad90a9305d9' where fk_char='a9690c9a-8b00-023c-83db-f58bd6b9666c';");
        $this->addSql('update public.characteristics set "id"=\'3aa37e2b-f198-48c1-b116-3ad90a9305d9\' where "id"=\'a9690c9a-8b00-023c-83db-f58bd6b9666c\';');
        $this->addSql('ALTER TABLE representation_values ENABLE TRIGGER ALL;');
        $this->addSql('ALTER TABLE values ENABLE TRIGGER ALL;');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
