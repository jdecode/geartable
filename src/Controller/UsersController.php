<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property UsersTable $Users
 * @method User[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['login', 'callback']);
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        // If the user is logged in send them away.
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/home';
            $this->redirect($target);
            exit();
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username or password');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function callback() {
        $user = (new GithubController())->userCallback($this->request->getQueryParams());
        $this->rdbmsAdd($user);
        $this->session->write(['Auth' => ['email' => $user['email'], 'name' => $user['name']]]);
        return $this->redirect('/sheets');
    }

    private function rdbmsAdd($userInfo): void
    {
        $this->Users->findOrCreate(['email' => $userInfo['email']],
            function ($entity) use ($userInfo) {
                $entity->name = $userInfo['name'];
        });
    }
}
