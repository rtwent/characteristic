<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210505155830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE representationvalue_sequence INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE characteristics (id UUID NOT NULL, measure_unit_id INT DEFAULT NULL, alias VARCHAR(50) NOT NULL, i18n JSONB DEFAULT \'{}\' NOT NULL, property JSONB DEFAULT \'{}\' NOT NULL, type VARCHAR(25) NOT NULL, old_vector_id INT DEFAULT NULL, old_form_builder JSONB DEFAULT \'{}\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7037B15663C6A475 ON characteristics (measure_unit_id)');
        $this->addSql('CREATE UNIQUE INDEX char_unique_alias ON characteristics (alias)');
        $this->addSql('CREATE UNIQUE INDEX char_unique_uuid ON characteristics (id)');
        $this->addSql('COMMENT ON COLUMN characteristics.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN characteristics.type IS \'(DC2Type:CharType)\'');
        $this->addSql('CREATE TABLE measure_units (id SERIAL NOT NULL, si_name VARCHAR(5) NOT NULL, i18n JSONB DEFAULT \'{}\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX measure_units_si_unique ON measure_units (si_name)');
        $this->addSql('CREATE TABLE out_representation (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX id ON out_representation (id)');
        $this->addSql('COMMENT ON COLUMN out_representation.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE representation_values (id INT DEFAULT nextval(\'representationvalue_sequence\'::regclass) NOT NULL, fk_rep_uuid UUID NOT NULL, fk_characteristic UUID NOT NULL, rep_char_values JSONB DEFAULT \'{}\' NOT NULL, settings JSONB DEFAULT \'{}\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C81BED3D21ABB379 ON representation_values (fk_rep_uuid)');
        $this->addSql('CREATE INDEX IDX_C81BED3D272140B9 ON representation_values (fk_characteristic)');
        $this->addSql('COMMENT ON COLUMN representation_values.fk_rep_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN representation_values.fk_characteristic IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE values (id UUID NOT NULL, fk_char UUID NOT NULL, i18n JSONB DEFAULT \'{}\' NOT NULL, key INT NOT NULL, default_sort INT NOT NULL, only_type JSONB DEFAULT \'[]\' NOT NULL, service_config JSONB DEFAULT \'[]\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, old_vector_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3AA74CE6C089A1 ON values (fk_char)');
        $this->addSql('CREATE UNIQUE INDEX char_translation ON values (fk_char, i18n)');
        $this->addSql('COMMENT ON COLUMN values.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN values.fk_char IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE characteristics ADD CONSTRAINT FK_7037B15663C6A475 FOREIGN KEY (measure_unit_id) REFERENCES measure_units (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE representation_values ADD CONSTRAINT FK_C81BED3D21ABB379 FOREIGN KEY (fk_rep_uuid) REFERENCES out_representation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE representation_values ADD CONSTRAINT FK_C81BED3D272140B9 FOREIGN KEY (fk_characteristic) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE values ADD CONSTRAINT FK_3AA74CE6C089A1 FOREIGN KEY (fk_char) REFERENCES characteristics (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE representation_values DROP CONSTRAINT FK_C81BED3D272140B9');
        $this->addSql('ALTER TABLE values DROP CONSTRAINT FK_3AA74CE6C089A1');
        $this->addSql('ALTER TABLE characteristics DROP CONSTRAINT FK_7037B15663C6A475');
        $this->addSql('ALTER TABLE representation_values DROP CONSTRAINT FK_C81BED3D21ABB379');
        $this->addSql('DROP SEQUENCE representationvalue_sequence CASCADE');
        $this->addSql('DROP TABLE characteristics');
        $this->addSql('DROP TABLE measure_units');
        $this->addSql('DROP TABLE out_representation');
        $this->addSql('DROP TABLE representation_values');
        $this->addSql('DROP TABLE values');
    }
}
