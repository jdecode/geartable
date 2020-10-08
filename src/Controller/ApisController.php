<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Google_Client;
use Google_Service_Sheets;

/**
 * Apis Controller
 *
 * @property \App\Model\Table\ApisTable $Apis
 * @method \App\Model\Entity\Api[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApisController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['execute']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Sheets', 'Users'],
        ];
        $apis = $this->paginate($this->Apis);

        $this->set(compact('apis'));
    }

    /**
     * View method
     *
     * @param string|null $id Api id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $api = $this->Apis->get($id, [
            'contain' => ['Sheets', 'Users'],
        ]);

        $this->set(compact('api'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $api = $this->Apis->newEmptyEntity();
        if ($this->request->is('post')) {
            $api = $this->Apis->patchEntity($api, $this->request->getData());
            if ($this->Apis->save($api)) {
                $this->Flash->success(__('The api has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The api could not be saved. Please, try again.'));
        }
        $sheets = $this->Apis->Sheets->find('list', ['limit' => 200]);
        $users = $this->Apis->Users->find('list', ['limit' => 200]);
        $this->set(compact('api', 'sheets', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Api id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $api = $this->Apis->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $api = $this->Apis->patchEntity($api, $this->request->getData());
            if ($this->Apis->save($api)) {
                $this->Flash->success(__('The api has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The api could not be saved. Please, try again.'));
        }
        $sheets = $this->Apis->Sheets->find('list', ['limit' => 200]);
        $users = $this->Apis->Users->find('list', ['limit' => 200]);
        $this->set(compact('api', 'sheets', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Api id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $api = $this->Apis->get($id);
        if ($this->Apis->delete($api)) {
            $this->Flash->success(__('The api has been deleted.'));
        } else {
            $this->Flash->error(__('The api could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function execute($hash) {
        $api = $this->Apis->find('all', [
            'conditions' => [
                'Apis.hash' => $hash,
                'Apis.active' => true
            ],
            'contain' => ['Sheets'],
            'limit' => 1
        ])->all();
        $api = $api->first();
        $this->response->getBody()->write(
            json_encode(
                (new Google_Service_Sheets(
                    new Google_Client([
                                          'scopes' => [Google_Service_Sheets::SPREADSHEETS_READONLY],
                                          'use_application_default_credentials' => true
                                      ])))
                    ->spreadsheets_values
                    ->get($api->sheet->id_sheet, $api->api_range)
                    ->getValues()
            )
        );
        return $this->response;
    }
}
