<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Api[]|\Cake\Collection\CollectionInterface $apis
 */
?>
<div class="apis index content">
    <?= $this->Html->link(__('New Api'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('APIs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th>
                        <?= $this->Paginator->sort('hash', 'URL') ?>
                        <br />
                        <i style="font-size:10px">
                            [Link opens in new tab]
                        </i>
                    </th>
                    <th><?= $this->Paginator->sort('sheet_id') ?></th>
                    <th><?= $this->Paginator->sort('api_range', 'Range') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($apis as $api): ?>
                <tr>
                    <td><?= $this->Number->format($api->id) ?></td>
                    <td><?= h($api->name) ?></td>
                    <td>
                        <?= $this->Html->link(__('Open'), '/api/'.h($api->hash), [
                            'class' => 'button',
                            'target' => '_blank'
                        ]) ?>
                    </td>
                    <td><?= $api->has('sheet') ? $this->Html->link($api->sheet->name, ['controller' => 'Sheets', 'action' => 'view', $api->sheet->id]) : '' ?></td>
                    <td><?= h($api->api_range) ?></td>
                    <td class="actions">
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
