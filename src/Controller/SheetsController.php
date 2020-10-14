<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Sheet;
use App\Model\Table\SheetsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Sheets Controller
 *
 * @property SheetsTable $Sheets
 * @method Sheet[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class SheetsController extends AppController
{
    private int $id_user;
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated([]);
        $this->id_user = $this->request->getAttribute('identity')->get('id');
    }
    /**
     * Index method
     *
     * @return Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            //'contain' => ['Users'],
        ];
        $sheets = $this->paginate($this->Sheets, [
            'conditions' => [
                'Sheets.user_id' => $this->id_user
            ]
        ]);

        $this->set(compact('sheets'));
    }

    /**
     * View method
     *
     * @param string|null $id Sheet id.
     * @return Response|null|void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sheet = $this->Sheets->find('all', [
            'conditions' => [
                'Sheets.id' => $id,
                'Sheets.user_id' => $this->id_user
            ],
            'limit' => 1
        ])
            ->contain(['Apis'])
            ->all()
            ->first();
        $this->set(compact('sheet'));
    }

    /**
     * Add method
     *
     * @return Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sheet = $this->Sheets->newEmptyEntity();
        if ($this->request->is('post')) {
            $sheet = $this->Sheets->patchEntity($sheet, $this->request->getData());
            if ($this->Sheets->save($sheet)) {
                $this->Flash->success(__('The sheet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sheet could not be saved. Please, try again.'));
        }
        $users = $this->Sheets->Users->find('list', ['limit' => 200]);
        $this->set(compact('sheet', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sheet id.
     * @return Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sheet = $this->Sheets->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sheet = $this->Sheets->patchEntity($sheet, $this->request->getData());
            if ($this->Sheets->save($sheet)) {
                $this->Flash->success(__('The sheet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sheet could not be saved. Please, try again.'));
        }
        $users = $this->Sheets->Users->find('list', ['limit' => 200]);
        $this->set(compact('sheet', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sheet id.
     * @return Response|null|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sheet = $this->Sheets->get($id);
        if ($this->Sheets->delete($sheet)) {
            $this->Flash->success(__('The sheet has been deleted.'));
        } else {
            $this->Flash->error(__('The sheet could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
