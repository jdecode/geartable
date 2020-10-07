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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sheet->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sheet->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Sheets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="sheets form content">
            <?= $this->Form->create($sheet) ?>
            <fieldset>
                <legend><?= __('Edit Sheet') ?></legend>
                <?php
                    echo $this->Form->control('id_sheet');
                    echo $this->Form->control('active');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>