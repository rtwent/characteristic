<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506113354 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Apartment complex characteristics update';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(' update "characteristics" set
            property
            =
            jsonb_set(property, \'{search,types}\', COALESCE (property->\'search\'->\'types\', \'[]\'::JSONB)  || \'["apartment_complex"]\'::JSONB)
            where alias in (
             \'without_percents\',
 \'video\',
 \'house_count\',
 \'floors_count\',
 \'housing_material\',
 \'wall_kind\',
 \'warming\',
 \'ceiling_height\',
 \'fk_geotop_id\',
 \'flats_amount\',
 \'territory\',
 \'parking_type\',
 \'services\',
 \'center_distance\',
 \'sea_distance\',
 \'shops_distance\',
 \'school_distance\',
 \'kindergarten_distance\',
 \'business_center_distance\',
 \'electricity_type\',
 \'adv_description\',
 \'complex_name\',
 \'www\',
 \'site\',
 \'heating_type\',
 \'fk_geo_id\',
 \'first_fee\',
 \'is_crediting_text\'
            
            )');
    }

    public function down(Schema $schema) : void
    {

    }
}
