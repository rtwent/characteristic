<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506115450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('update "characteristics" set
            property
            =
            \'{"search": {"types": ["apartment_complex"], "categories": ["main"]}}\'
            where alias in (
             \'adv_description\',
 \'business_center_distance\',
 \'center_distance\',
 \'complex_name\',
 \'first_fee\',
 \'flats_amount\',
 \'house_count\',
 \'kindergarten_distance\',
 \'parking_type\',
 \'school_distance\',
 \'sea_distance\',
 \'services\',
 \'shops_distance\',
 \'site\',
 \'territory\',
 \'video\',
 \'wall_kind\',
 \'warming\',
 \'without_percents\'
            )');
    }

    public function down(Schema $schema) : void
    {
    }
}
