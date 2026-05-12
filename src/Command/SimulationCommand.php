<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\TableRegistry;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class SimulationCommand extends Command
{
    public static function defaultName(): string
    {
        return 'simulation';
    }

    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->addOption('reset', [
            'help' => 'Reset the database before simulation',
            'boolean' => true,
        ]);
        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $io->out('Starting System Simulation Data Population...');

        $rolesTable = TableRegistry::getTableLocator()->get('Roles');
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $proceduresTable = TableRegistry::getTableLocator()->get('Procedures');
        $requirementsTable = TableRegistry::getTableLocator()->get('Requirements');
        $procReqTable = TableRegistry::getTableLocator()->get('Procedurerequirements');
        $requestsTable = TableRegistry::getTableLocator()->get('Requests');
        $reqTypesTable = TableRegistry::getTableLocator()->get('Requirementtypes');

        if ($args->getOption('reset')) {
            $io->out('Resetting tables...');
            $connection = $rolesTable->getConnection();
            $connection->execute('SET FOREIGN_KEY_CHECKS = 0');
            $connection->execute('TRUNCATE TABLE requestrequirements');
            $connection->execute('TRUNCATE TABLE procedurerequirements');
            $connection->execute('TRUNCATE TABLE requests');
            $connection->execute('TRUNCATE TABLE requirements');
            $connection->execute('TRUNCATE TABLE procedures');
            $connection->execute('TRUNCATE TABLE users');
            $connection->execute('TRUNCATE TABLE roles');
            $connection->execute('TRUNCATE TABLE requirementtypes');
            $connection->execute('SET FOREIGN_KEY_CHECKS = 1');
        }

        // 1. Roles
        $io->out('Creating Roles...');
        $rolesData = [
            ['id_role' => 1, 'name' => 'Client', 'description' => 'End user of the application'],
            ['id_role' => 2, 'name' => 'Agent', 'description' => 'Staff member who manages requests'],
            ['id_role' => 3, 'name' => 'Administrator', 'description' => 'Full system access'],
        ];
        foreach ($rolesData as $role) {
            $entity = $rolesTable->newEntity($role);
            $rolesTable->save($entity);
        }
        
        $roleMap = $rolesTable->find('list', ['keyField' => 'name', 'valueField' => 'id_role'])->toArray();

        // 2. Requirement Types
        $io->out('Creating Requirement Types...');
        $typesData = [
            ['type' => 'formulaire', 'name' => 'Form Requirement', 'Description' => 'A requirement that needs form data input', 'deleted' => 0],
            ['type' => 'file', 'name' => 'File Requirement', 'Description' => 'A requirement that needs a file upload', 'deleted' => 0],
        ];
        foreach ($typesData as $type) {
            $entity = $reqTypesTable->newEntity($type);
            $reqTypesTable->save($entity);
        }

        // 3. Users
        $io->out('Creating Users...');
        $usersData = [
            [
                'name' => 'Admin',
                'surname' => 'System',
                'email' => 'admin@example.com',
                'password' => 'admin123',
                'id_role' => $roleMap['Administrator'],
                'phonenumber' => 123456789,
                'Verifications' => 1
            ],
            [
                'name' => 'Agent',
                'surname' => 'Support',
                'email' => 'agent@example.com',
                'password' => 'agent123',
                'id_role' => $roleMap['Agent'],
                'phonenumber' => 987654321,
                'Verifications' => 1
            ],
            [
                'name' => 'John',
                'surname' => 'Doe',
                'email' => 'client@example.com',
                'password' => 'client123',
                'id_role' => $roleMap['Client'],
                'phonenumber' => 555000111,
                'Verifications' => 1
            ],
        ];

        $users = [];
        foreach ($usersData as $userData) {
            $user = $usersTable->find()->where(['email' => $userData['email']])->first();
            if (!$user) {
                $user = $usersTable->newEntity($userData);
                $usersTable->save($user);
            }
            $users[$userData['name']] = $user;
        }

        // 4. Procedures
        $io->out('Creating Procedures...');
        $proceduresData = [
            [
                'name' => 'Passeport National',
                'type' => 'Administration',
                'description' => 'Demande de passeport biométrique.', // 33 chars
                'deleted' => 0,
                'image' => 'passport.png'
            ],
            [
                'name' => 'Permis de Conduire',
                'type' => 'Transport',
                'description' => 'Obtention du permis de conduire.', // 31 chars
                'deleted' => 0,
                'image' => 'driver_license.png'
            ],
        ];

        $procedures = [];
        foreach ($proceduresData as $procData) {
            $proc = $proceduresTable->find()->where(['name' => $procData['name']])->first();
            if (!$proc) {
                $proc = $proceduresTable->newEntity($procData);
                $proceduresTable->save($proc);
            }
            $procedures[$procData['name']] = $proc;
        }

        // 5. Requirements
        $io->out('Creating Requirements...');
        // Map types to IDs
        $typeMap = $reqTypesTable->find('list', ['keyField' => 'type', 'valueField' => 'id'])->toArray();
        
        $requirementsData = [
            ['name' => 'Photo d\'identité', 'requirementtype_id' => $typeMap['file'], 'description' => 'Format 35x45mm, fond clair.', 'status' => 'active', 'deleted' => 0],
            ['name' => 'Justificatif de domicile', 'requirementtype_id' => $typeMap['file'], 'description' => 'Facture de moins de 3 mois.', 'status' => 'active', 'deleted' => 0],
            ['name' => 'Copie CNI', 'requirementtype_id' => $typeMap['file'], 'description' => 'Recto/Verso de la CNI.', 'status' => 'active', 'deleted' => 0],
            ['name' => 'Formulaire de renseignement', 'requirementtype_id' => $typeMap['formulaire'], 'description' => 'Vos informations personnelles.', 'status' => 'active', 'deleted' => 0],
        ];

        $requirements = [];
        foreach ($requirementsData as $reqData) {
            $req = $requirementsTable->find()->where(['name' => $reqData['name']])->first();
            if (!$req) {
                $req = $requirementsTable->newEntity($reqData);
                $requirementsTable->save($req);
            }
            $requirements[$reqData['name']] = $req;
        }

        // 6. Link Procedures to Requirements
        $io->out('Linking Procedures to Requirements...');
        $links = [
            'Passeport National' => ['Photo d\'identité', 'Justificatif de domicile', 'Formulaire de renseignement'],
            'Permis de Conduire' => ['Photo d\'identité', 'Copie CNI'],
        ];

        foreach ($links as $procName => $reqNames) {
            $procId = $procedures[$procName]->id;
            foreach ($reqNames as $reqName) {
                $reqId = $requirements[$reqName]->id;
                if (!$procReqTable->exists(['procedure_id' => $procId, 'requirement_id' => $reqId])) {
                    $entity = $procReqTable->newEntity([
                        'procedure_id' => $procId,
                        'requirement_id' => $reqId,
                        'deleted' => 0
                    ], ['accessibleFields' => ['*' => true]]);
                    $procReqTable->save($entity);
                }
            }
        }

        // 7. Sample Request
        $io->out('Creating Sample Requests...');
        $requestData = [
            'user_id' => $users['John']->id,
            'procedure_id' => $procedures['Passeport National']->id,
            'status' => 'pending',
            'deleted' => 0
        ];
        
        if (!$requestsTable->exists(['user_id' => $requestData['user_id'], 'procedure_id' => $requestData['procedure_id']])) {
            $request = $requestsTable->newEntity($requestData, ['accessibleFields' => ['*' => true]]);
            $requestsTable->save($request);
        }

        $io->success('Simulation data populated successfully!');
        $io->out('--------------------------------------------------');
        $io->out('Use the following credentials to test the system:');
        $io->out('Admin: admin@example.com / admin123');
        $io->out('Agent: agent@example.com / agent123');
        $io->out('Client: client@example.com / client123');
        $io->out('--------------------------------------------------');

        return static::CODE_SUCCESS;
    }
}
