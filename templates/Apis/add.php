<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Api $api
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('All Apis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="apis form content">
            <?= $this->Form->create($api) ?>
            <fieldset>
                <legend><?= __('Add API') ?></legend>
                <?php
                echo $this->Form->control('sheet_id', ['options' => $sheets, 'default' => $sheet_id]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('hash', ['label' => 'URL', 'placeholder' => 'Should be unique (e.g. "web-dashboard-stats")']);
                    echo $this->Form->control('api_range', [
                        'label' => 'Range'
                    ]);
                    echo $this->Form->control('header', [
                        'type' => 'checkbox',
                        'label' => 'Has headers (first row will become header, otherwise associative/numeric indices of columns in an array)'
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Html->link(__('Back'), ($sheet_id ? '/sheets/view/'.$sheet_id : '/apis'), [
                'class' => 'button button-outline'
            ]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
