<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506135553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('update values set only_type=\'["apartment_complex"]\'::JSONB where fk_char in (
\'eea1aa2b-95df-4838-94de-6a2fdc6a130d\',
\'13908407-cb74-4bd8-bb24-be207473b24f\',
\'426ba835-89a0-4b60-8086-0006e63531e5\',
\'a9690c9a-8b00-023c-83db-f58bd6b9666c\'
)');
        $this->addSql('update "representation_values" set rep_char_values=\'{"816fbe85-ffdd-4585-acb1-dcddf7331806": {"sort": 1}, "a6fa3d22-1560-4159-80a3-866e26794335": {"sort": 2}, "74849289-750d-4370-83a5-232fbef2167f": {"sort": 3}, "58e6bd81-ac06-4a32-aa32-f3102c149e88": {"sort": 4}, "4ece03ab-2c83-4112-a1c7-0fa675d17f5a": {"sort": 5}, "caa3f2ec-3b99-4b26-b1da-f982658ea37c": {"sort": 6}}\' 
where fk_rep_uuid=\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\' and fk_characteristic=\'a9690c9a-8b00-023c-83db-f58bd6b9666c\'');
        $this->addSql('update "representation_values" set rep_char_values= \'{ "426ba835-89a0-4b60-8086-0006e63531e5": {"sort": 1}}\' 
where fk_rep_uuid=\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\' and fk_characteristic=\'426ba835-89a0-4b60-8086-0006e63531e5\'');
        $this->addSql('update "representation_values" set rep_char_values= \'{"36ac5e96-1c0c-44a7-96c8-beea2beda994": {"sort": 1}, "a18d710c-dd7e-4b1c-84b1-669a577d8204": {"sort": 2}, "00ed2ea1-0b08-4dd8-99ae-0f11720fb97a": {"sort": 3}, "80b2bd55-f228-4d2e-9028-21ca528c9634": {"sort": 4}, "12894331-d28e-4d8b-a71a-4849dc47de04": {"sort": 5}}\' 
where fk_rep_uuid=\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\' and fk_characteristic=\'13908407-cb74-4bd8-bb24-be207473b24f\'');
        $this->addSql('update "representation_values" set rep_char_values=\'{"7253d5a8-26d2-4dba-a436-80ab06a5fc1d": {"sort": 1}, "3c29bbd3-90da-42c2-b731-4c2c849cc61e": {"sort": 2}, "84fd0f76-98dc-4034-a1b2-1bb29ee8260b": {"sort": 3}, "51abed9b-d64a-4ef8-a7f0-a37705b126d8": {"sort": 4}, "a5785eac-823c-4190-b01a-c6c592b15e04": {"sort": 5}}\'
where fk_rep_uuid=\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\' and fk_characteristic=\'eea1aa2b-95df-4838-94de-6a2fdc6a130d\'');
    }

    public function down(Schema $schema) : void
    {
    }
}
