<?php
echo '<div id=center>';
echo $this->Form->create('Member', array('action' => 'login'));
echo $this->Form->input('username', array('label' => '帳號'));
echo $this->Form->input('password', array('label' => '密碼'));
echo $this->Form->end(__('登入系統', true));
echo '</div>';
