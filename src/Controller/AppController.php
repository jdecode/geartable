<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Aws\Sdk;
use Cake\Controller\Controller;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Session;
use PDA\PDA;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public PDA $pda;
    public DynamoDbClient $dynamoDb;
    public Marshaler $marshaler;
    public Session $session;
    protected int $id_user;
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');

        $this->dynamoDb = (new Sdk([
                                       'region' => env('DDB_REGION', 'ap-south-1'),
                                       'version' => env('DDB_VERSION', 'latest')
                                   ]))->createDynamoDb();
        $this->pda = new PDA($this->dynamoDb);
        $this->marshaler = new Marshaler();
        $this->session = new Session();
        $_identifier = $this->request->getAttribute('identity');
        if(!is_null($_identifier)) {
            $this->id_user = $_identifier->get('id');
        }
    }

    public function error($message = '', $code = 404)
    {
        throw new NotFoundException($message, $code);
    }

    public function resp($data = [], $code = 200)
    {
        $this->response = $this->response->withType('application/json');
        $this->response = $this->response->withStatus($code);
        $this->response = $this->response->withStringBody(json_encode($data));
        return $this->response;
    }
}
