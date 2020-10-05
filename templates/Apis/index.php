<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Api[]|\Cake\Collection\CollectionInterface $apis
 */
?>
<div class="apis index content">
    <?= $this->Html->link(__('New Api'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Apis') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('hash') ?></th>
                    <th><?= $this->Paginator->sort('sheet_id') ?></th>
                    <th><?= $this->Paginator->sort('active') ?></th>
                    <th><?= $this->Paginator->sort('api_range') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($apis as $api): ?>
                <tr>
                    <td><?= $this->Number->format($api->id) ?></td>
                    <td><?= h($api->name) ?></td>
                    <td><?= h($api->hash) ?></td>
                    <td><?= $api->has('sheet') ? $this->Html->link($api->sheet->name, ['controller' => 'Sheets', 'action' => 'view', $api->sheet->id]) : '' ?></td>
                    <td><?= h($api->active) ?></td>
                    <td><?= h($api->api_range) ?></td>
                    <td><?= $api->has('user') ? $this->Html->link($api->user->name, ['controller' => 'Users', 'action' => 'view', $api->user->id]) : '' ?></td>
                    <td><?= h($api->created) ?></td>
                    <td><?= h($api->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $api->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $api->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $api->id], ['confirm' => __('Are you sure you want to delete # {0}?', $api->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
