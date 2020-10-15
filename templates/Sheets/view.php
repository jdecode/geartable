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
            <i>
                <?= $this->Html->link( '[Open sheet in new tab]', 'https://docs.google.com/spreadsheets/d/'.$sheet->id_sheet, ['target' => '_blank']) ?>
            </i>
            <div class="related">
                <?= $this->Html->link(__('New API'), ['controller' => 'Apis', 'action' => 'add', $sheet->id], ['class' => 'button float-right']) ?>
                <br />
                <?php if (!empty($sheet->apis)) : ?>
                <h4><?= __('APIs') ?></h4>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Hash') ?></th>
                            <th><?= __('Api Range') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($sheet->apis as $apis) : ?>
                        <tr>
                            <td><?= h($apis->name) ?></td>
                            <td><?= h($apis->hash) ?></td>
                            <td><?= h($apis->api_range) ?></td>
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
