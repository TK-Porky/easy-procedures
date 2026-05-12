<?php
declare(strict_types=1);

namespace App\Controller\Agent;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        $this->set('title', 'Agent Dashboard');
    }
}
