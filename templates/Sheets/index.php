<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sheet[]|\Cake\Collection\CollectionInterface $sheets
 */
?>
<div class="sheets index content">
    <?= $this->Html->link(__('New Sheet'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Sheets') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sheets as $sheet): ?>
                <tr>
                    <td><?= $this->Number->format($sheet->id) ?></td>
                    <td>
                        <?= $this->Html->link(h($sheet->name), ['action' => 'view', $sheet->id]) ?>
                    </td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $sheet->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sheet->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sheet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sheet->id)]) ?>
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
