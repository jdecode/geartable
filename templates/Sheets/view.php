<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sheet $sheet
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Sheet'), ['action' => 'edit', $sheet->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Sheet'), ['action' => 'delete', $sheet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sheet->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Sheets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Sheet'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="sheets view content">
            <h3><?= h($sheet->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id Sheet') ?></th>
                    <td><?= h($sheet->id_sheet) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $sheet->has('user') ? $this->Html->link($sheet->user->name, ['controller' => 'Users', 'action' => 'view', $sheet->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($sheet->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($sheet->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($sheet->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($sheet->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active') ?></th>
                    <td><?= $sheet->active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Apis') ?></h4>
                <?php if (!empty($sheet->apis)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Hash') ?></th>
                            <th><?= __('Sheet Id') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Api Range') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($sheet->apis as $apis) : ?>
                        <tr>
                            <td><?= h($apis->id) ?></td>
                            <td><?= h($apis->name) ?></td>
                            <td><?= h($apis->hash) ?></td>
                            <td><?= h($apis->sheet_id) ?></td>
                            <td><?= h($apis->active) ?></td>
                            <td><?= h($apis->api_range) ?></td>
                            <td><?= h($apis->user_id) ?></td>
                            <td><?= h($apis->created) ?></td>
                            <td><?= h($apis->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Apis', 'action' => 'view', $apis->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Apis', 'action' => 'edit', $apis->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Apis', 'action' => 'delete', $apis->id], ['confirm' => __('Are you sure you want to delete # {0}?', $apis->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
