<?php

declare(strict_types=1);

namespace App\Controller;

use Aws\DynamoDb\Exception\DynamoDbException;
use Cake\Http\Client;

/**
 * Github Controller
 *
 */
class GithubController extends AppController
{
    private string $hashBabyHash = 'whatislovebabydonthurtme';

    private string $curlGithubUrl = '';

    private string $curlGithubToken = '';

    private array $curlGithubHeaders = [];

    private array $curlGithubPostdata = [];

    private bool $isPostJson = false;

    private Client $http;

    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['initialize', 'oauth', 'callback']);

        $this->setCurlGithubHeaders('User-Agent: jdecode');
        $this->http = new Client();
    }

    private function getGithubUrl()
    {
        return 'https://github.com/login/oauth/authorize?'
            . 'client_id=' . env('OAUTHAPP_GITHUB_CLIENT_ID')
            . '&redirect_uri=' . env('OAUTHAPP_GITHUB_REDIRECT_URI')
            . '&state=' . $this->hashBabyHash
            . '&scope=' . $this->getScopes();
    }

    private function getScopes()
    {
        $scopes = [
            'user:email'
        ];
        return implode(' ', $scopes);
    }

    public function userCallback($params)
    {
        $github_return = $params;
        if (isset($github_return['code']) && strlen(trim($github_return['code']))) {
            $postvars = [
                'code' => $github_return['code'],
                'client_id' => env('OAUTHAPP_GITHUB_CLIENT_ID'),
                'client_secret' => env('OAUTHAPP_GITHUB_CLIENT_SECRET'),
                'redirect_uri' => env('OAUTHAPP_GITHUB_REDIRECT_URI'),
                'state' => $this->hashBabyHash
            ];
            $this->curlGithubUrl = 'https://github.com/login/oauth/access_token';
            $this->setCurlGithubPost($postvars);
            return $this->getUser($this->getAccessTokenFromParams($this->curlGithub()));
        }
        return null;
    }

    private function getAccessTokenFromParams($params, $key = null)
    {
        $key = $key ?? 'access_token';
        $_params = explode('&', $params);
        foreach ($_params as $_param) {
            if (stristr($_param, $key . '=')) {
                $val =  explode('=', $_param);
                return $val[1];
            }
        }
        return '';
    }

    private function curlGithub()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->curlGithubUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getCurlGithubHeaders());
        if (count($this->curlGithubPostdata)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            if ($this->isPostJson) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->curlGithubPostdata));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($this->curlGithubPostdata));
            }
        }
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    private function setCurlGithubHeaders(string $header)
    {
        $this->curlGithubHeaders[] = $header;
    }

    private function setCurlGithubPost(array $postvars)
    {
        if (!count($this->curlGithubPostdata)) {
            $this->curlGithubPostdata = $postvars;
            return;
        }
        $this->curlGithubPostdata[] = $postvars;
    }

    /**
     * @return array
     */
    private function getCurlGithubHeaders()
    {
        if (strlen(trim($this->curlGithubToken))) {
            $this->setCurlGithubHeaders('Authorization: Bearer ' . $this->curlGithubToken);
        }
        return $this->curlGithubHeaders;
    }

    public function oauth()
    {
        return $this->redirect($this->getGithubUrl());
    }

    private function userInfo(string $access_token)
    {
        $ccn = curl_init();

        curl_setopt($ccn, CURLOPT_URL, 'https://api.github.com/user');
        curl_setopt($ccn, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ccn, CURLOPT_HTTPHEADER, array(
            'User-Agent: jdecode',
            "Authorization: token {$access_token}"
        ));

        $info = curl_exec($ccn);
        curl_close($ccn);
        return $info;
    }

    private function getUser($access_token)
    {
        $user = json_decode($this->userInfo($access_token), true);
        if(empty($user['email'])) {
            $this->error('Error from GitHub', 404);
        }
        $profile = [
            'pk' => 'USER#'.$user['email'],
            'sk' => '#PROFILE#'.$user['email'],
            'name' => $user['name'],
            'source' => 'github',
            'github' => [
                'name' => $user['name'],
                'login' => $user['login'],
                'nodeid' => $user['node_id'],
                'photo' => $user['avatar_url']
            ],
            'active' => true,
            'created' => time()
        ];

        try {
            $params = [
                'TableName' => 'geartable',
                'KeyConditionExpression' => "pk = :pk",
                'ExpressionAttributeValues' => [
                    ':pk' => [
                        'S' => $profile['pk']
                    ]
                ],
                'Limit' => 1
            ];
            $resp = $this->dynamoDb->query($params);
            if (!$resp['Count']) {
                $this->pda->insert('geartable', array_keys($profile), [array_values($profile)]);
            }
            return [
                'email' => $user['email'],
                'name' => $user['name']
            ];
        } catch (DynamoDbException $DynamoDbException) {
            dd($DynamoDbException);
        }
    }
}
