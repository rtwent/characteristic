<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506081212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Recalculating of vector ids in rep values to uuid';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('UPDATE representation_values set rep_char_values=subquery.recalculatedjson

        FROM 
        (SELECT
        unpacked."id" as unpackedid,
        "jsonb_object_agg"(unpacked.valueuuid, unpacked.v) as recalculatedjson
        
        FROM (
            SELECT 
            id, k, v,
            (select "id" from "values" where ("values".old_vector_id)::TEXT=k and "values".fk_char=fk_characteristic) as valueuuid
            FROM "representation_values",
            jsonb_each(rep_char_values) as e(k, v)
            where (select "id" from "values" where ("values".old_vector_id)::TEXT=k and "values".fk_char=fk_characteristic) is not NULL
        ) unpacked
        
        GROUP BY unpacked."id"
        ) as subquery
        
        WHERE representation_values."id"=subquery.unpackedid');
    }

    public function down(Schema $schema): void
    {
    }
}
