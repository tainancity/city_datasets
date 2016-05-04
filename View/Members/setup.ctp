<?php

echo $this->Form->create('Member', array('action' => 'setup'));
echo $this->Form->input('username', array('label' => '建立新帳號'));
echo $this->Form->input('password', array('type' => 'password', 'value' => '','label' => '輸入密碼'));
echo $this->Form->end(__('Create Administrator', true));
