<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class DashboardController extends AppController
{
    public function index()
    {
        $requestsTable = $this->fetchTable('Requests');
        $proceduresTable = $this->fetchTable('Procedures');
        $usersTable = $this->fetchTable('Users');

        // Global Statistics
        $totalRequests = $requestsTable->find()->count();
        $totalProcedures = $proceduresTable->find()->where(['deleted' => 0])->count();
        $totalUsers = $usersTable->find()->where(['deleted' => 0])->count();

        // Requests grouped by status
        $query = $requestsTable->find();
        $statusCounts = $query->select(['status', 'count' => $query->func()->count('*')])
            ->group('status')
            ->toArray();
            
        $pendingRequests = 0;
        $approvedRequests = 0;
        $rejectedRequests = 0;
        
        foreach ($statusCounts as $stat) {
            $status = strtolower($stat->status);
            if (in_array($status, ['pending', 'en attente', 'attente'])) {
                $pendingRequests += $stat->count;
            } elseif (in_array($status, ['approved', 'approuvée', 'approuve', 'validee', 'validée', 'acceptee'])) {
                $approvedRequests += $stat->count;
            } elseif (in_array($status, ['rejected', 'rejetée', 'rejete', 'refusee'])) {
                $rejectedRequests += $stat->count;
            }
        }

        // 5 Most recent requests
        $recentRequests = $requestsTable->find()
            ->contain(['Users', 'Procedures'])
            ->order(['Requests.created' => 'DESC'])
            ->limit(5)
            ->all();

        $this->set(compact(
            'totalRequests', 
            'pendingRequests', 
            'approvedRequests', 
            'rejectedRequests', 
            'totalProcedures', 
            'totalUsers', 
            'recentRequests'
        ));
    }
}
