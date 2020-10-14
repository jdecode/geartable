<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Sheet;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sheets Model
 *
 * @property UsersTable&BelongsTo $Users
 * @property ApisTable&HasMany $Apis
 *
 * @method Sheet newEmptyEntity()
 * @method Sheet newEntity(array $data, array $options = [])
 * @method Sheet[] newEntities(array $data, array $options = [])
 * @method Sheet get($primaryKey, $options = [])
 * @method Sheet findOrCreate($search, ?callable $callback = null, $options = [])
 * @method Sheet patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Sheet[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method Sheet|false save(EntityInterface $entity, $options = [])
 * @method Sheet saveOrFail(EntityInterface $entity, $options = [])
 * @method Sheet[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method Sheet[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method Sheet[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method Sheet[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin TimestampBehavior
 */
class SheetsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sheets');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Apis', [
            'foreignKey' => 'sheet_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('id_sheet')
            ->maxLength('id_sheet', 255)
            ->requirePresence('id_sheet', 'create')
            ->notEmptyString('id_sheet');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
