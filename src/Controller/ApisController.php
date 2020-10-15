<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
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
     * @return Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Sheets', 'Users'],
        ];
        $apis = $this->paginate($this->Apis, [
            'conditions' => [
                'Sheets.user_id' => $this->id_user
            ]
        ]);

        $this->set(compact('apis'));
    }

    /**
     * Add method
     *
     * @param int $sheet_id
     * @return Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($sheet_id = 0)
    {
        $api = $this->Apis->newEmptyEntity();
        if ($this->request->is('post')) {
            $api = $this->Apis->patchEntity($api, $this->request->getData());
            $api->user_id = $this->id_user;
            $api->active = 1;
            if ($this->Apis->save($api)) {
                $this->Flash->success(__('The api has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The api could not be saved. Please, try again.'));
        }
        $sheets = $this->Apis->Sheets->find('list', [
            'conditions' => [
                'Sheets.user_id' => $this->id_user
            ],
            'limit' => 200
        ]);
        $this->set(compact('api', 'sheets', 'sheet_id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Api id.
     * @return Response|null|void Redirects to index.
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
