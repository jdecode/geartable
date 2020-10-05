<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Api Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string $hash
 * @property int $sheet_id
 * @property bool|null $active
 * @property string $api_range
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Sheet $sheet
 * @property \App\Model\Entity\User $user
 */
class Api extends Entity
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
        'name' => true,
        'hash' => true,
        'sheet_id' => true,
        'active' => true,
        'api_range' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'sheet' => true,
        'user' => true,
    ];
}
