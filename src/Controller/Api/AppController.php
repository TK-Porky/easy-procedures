<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

/**
 * API AppController
 */
class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Authentication.Authentication');

        // Force JSON response
        $this->viewBuilder()->setClassName('Json');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Strictly enforce authentication for all API endpoints
        // Exception: login endpoint (handled in sub-controllers if needed)
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        
        // Ensure data is serialized to JSON
        $this->viewBuilder()->setOption('serialize', true);
    }
}
