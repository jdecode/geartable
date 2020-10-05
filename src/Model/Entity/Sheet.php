<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sheet Entity
 *
 * @property int $id
 * @property string $id_sheet
 * @property bool|null $active
 * @property int $user_id
 * @property string|null $name
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Api[] $apis
 */
class Sheet extends Entity
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
        'id_sheet' => true,
        'active' => true,
        'user_id' => true,
        'name' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'apis' => true,
    ];
}
