<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220504062635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX representation_characteristic ON representation_values (fk_rep_uuid, fk_characteristic)');
        $this->addSql('ALTER INDEX idx_c81bed3d272140b9 RENAME TO representation_values_char_idx');
        $this->addSql('ALTER INDEX idx_c81bed3d21abb379 RENAME TO representation_values_representation_idx');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE measure_units ALTER i18n TYPE JSONB');
        $this->addSql('ALTER TABLE measure_units ALTER i18n SET DEFAULT \'{}\'');
        $this->addSql('DROP INDEX representation_characteristic');
        $this->addSql('ALTER TABLE representation_values ALTER id DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE representation_values_id_seq');
        $this->addSql('SELECT setval(\'representation_values_id_seq\', (SELECT MAX(id) FROM representation_values))');
        $this->addSql('ALTER TABLE representation_values ALTER id SET DEFAULT nextval(\'representation_values_id_seq\')');
        $this->addSql('ALTER TABLE representation_values ALTER rep_char_values TYPE JSONB');
        $this->addSql('ALTER TABLE representation_values ALTER rep_char_values SET DEFAULT \'{}\'');
        $this->addSql('ALTER TABLE representation_values ALTER settings TYPE JSONB');
        $this->addSql('ALTER TABLE representation_values ALTER settings SET DEFAULT \'{}\'');
        $this->addSql('ALTER INDEX representation_values_char_idx RENAME TO idx_c81bed3d272140b9');
        $this->addSql('ALTER INDEX representation_values_representation_idx RENAME TO idx_c81bed3d21abb379');
        $this->addSql('ALTER TABLE characteristics ALTER i18n TYPE JSONB');
        $this->addSql('ALTER TABLE characteristics ALTER i18n SET DEFAULT \'{}\'');
        $this->addSql('ALTER TABLE characteristics ALTER property TYPE JSONB');
        $this->addSql('ALTER TABLE characteristics ALTER property SET DEFAULT \'{}\'');
        $this->addSql('ALTER TABLE values ALTER i18n TYPE JSONB');
        $this->addSql('ALTER TABLE values ALTER i18n SET DEFAULT \'{}\'');
        $this->addSql('ALTER TABLE values ALTER only_type TYPE JSONB');
        $this->addSql('ALTER TABLE values ALTER only_type SET DEFAULT \'[]\'');
        $this->addSql('ALTER TABLE values ALTER service_config TYPE JSONB');
        $this->addSql('ALTER TABLE values ALTER service_config SET DEFAULT \'[]\'');
    }
}
