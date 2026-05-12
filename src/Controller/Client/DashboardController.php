<?php
declare(strict_types=1);

namespace App\Controller\Client;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        $this->set('title', 'Client Dashboard');
    }
}
