<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;


/**
 * User Entity
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string|null $name
 * @property bool|null $active
 * @property bool|null $email_verified
 * @property \Cake\I18n\FrozenTime|null $email_verified_at
 * @property string|null $remember_me_token
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'password' => true,
        'name' => true,
        'active' => true,
        'email_verified' => true,
        'email_verified_at' => true,
        'remember_me_token' => true,
        'created' => true,
        'modified' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
    protected function _setPassword(string $password)
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($password);
    }
}
