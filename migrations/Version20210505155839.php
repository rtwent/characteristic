<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210505155839 extends AbstractMigration
{
    public function getDescription(): string
    {
        // SELECT '$this->addSql(' || chr(39) || 'insert into out_representation ("id", "created_at") VALUES (' || chr(92) || chr(39) || microservice_migration || chr(92) || chr(39) || ', ' || chr(92) || chr(39) || created_at || chr(92) || chr(39) || ') ' || chr(39) || ');' FROM "representations" where deleted_at is NULL
        return 'Fill the table of representations. The auto query is in comment';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'2019-05-02 09:45:11\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'25b840f7-e66a-42fe-8afc-8449a16da4e8\', \'2019-09-17 12:31:44\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'30007f41-7c2d-4849-8306-fddfbb6bf18a\', \'2019-12-10 14:23:59\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'af038b58-4d3d-4973-a22d-4b9927e2fd62\', \'2020-01-09 12:51:37\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'00ff1b37-3060-4058-8377-4f9a0973bb5b\', \'2020-01-30 09:44:25\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'d43d913e-f235-4081-9488-cd8520f23509\', \'2020-01-30 09:48:50\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'afeb43b9-616b-4af9-88c8-9935cb3c2f6c\', \'2020-02-26 11:39:53\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'86117eca-5bcd-4a7a-a05a-72c4789253c3\', \'2020-02-26 11:40:55\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'594dc2ae-e037-40c3-9a3c-e83c47c71cb7\', \'2020-02-26 11:41:35\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'5d1de474-97fc-49f8-8084-a567a8951b9a\', \'2020-02-26 11:42:27\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'1df9c240-16f3-48d1-a399-1552d690b383\', \'2020-02-26 11:44:01\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'9450ed63-d046-48d7-861f-8d440a7910eb\', \'2020-02-26 11:45:28\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'881343a4-e5cf-42f8-a829-914f0e08e050\', \'2020-02-26 11:46:18\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'068cb5d0-0f94-4265-86e1-2af4af4036b6\', \'2020-02-26 11:52:07\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'f9ae7412-0387-42c4-a4d1-a6ebefb4c9f0\', \'2020-02-26 11:53:31\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'00f1e3d2-7c76-429c-ad6e-0c0d87642505\', \'2020-02-26 11:54:18\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'4cc7dd42-87bd-4a0e-be48-c1d3ac38400f\', \'2020-02-26 11:55:13\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'81fa7010-6605-416c-b77c-e6479925243b\', \'2020-02-26 11:56:57\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'8c8f4934-f49d-4a58-a784-c66b7b8bf026\', \'2020-02-26 11:57:44\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'9b9e3624-284c-4a3d-a9e0-e57739eb2ddb\', \'2020-02-26 12:00:24\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'17230889-2283-4ba6-9842-06a8d67f33a2\', \'2020-02-26 12:02:02\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'8324dc7c-7693-450a-bbce-b696254285f8\', \'2020-09-07 15:02:16\') ');
        $this->addSql('insert into out_representation ("id", "created_at") VALUES (\'1c8ae28f-2fe9-4300-a542-a529b22c412e\', \'2019-08-27 12:28:32\') ');
    }

    public function down(Schema $schema): void
    {
    }
}
