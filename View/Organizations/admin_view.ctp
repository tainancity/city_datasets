<div id="OrganizationsAdminView">
    <h3><?php echo __('View 組織', true); ?></h3><hr />
    <div class="col-md-12">

        <div class="col-md-2">父項目</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Organization']['parent_id']) {

                echo $this->data['Organization']['parent_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">名稱</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Organization']['name']) {

                echo $this->data['Organization']['name'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">原始編號</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Organization']['foreign_id']) {

                echo $this->data['Organization']['foreign_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">原始網址</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Organization']['foreign_uri']) {

                echo $this->data['Organization']['foreign_uri'];
            }
            ?>&nbsp;
        </div>
    </div>
    <hr />
    <div class="btn-group">
        <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Organization.id')), array('class' => 'btn btn-default'), __('Delete the item, sure?', true)); ?>
        <?php echo $this->Html->link(__('組織 List', true), array('action' => 'index'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link(__('View Related 資料集', true), array('controller' => 'datasets', 'action' => 'index', 'Organization', $this->data['Organization']['id']), array('class' => 'btn btn-default OrganizationsAdminViewControl')); ?>
        <?php echo $this->Html->link(__('View Related 標籤', true), array('controller' => 'tags', 'action' => 'index', 'Organization', $this->data['Organization']['id']), array('class' => 'btn btn-default OrganizationsAdminViewControl')); ?>
        <?php echo $this->Html->link(__('Set Related 標籤', true), array('controller' => 'tags', 'action' => 'index', 'Organization', $this->data['Organization']['id'], 'set'), array('class' => 'btn btn-default OrganizationsAdminViewControl')); ?>
    </div>
    <div id="OrganizationsAdminViewPanel"></div>
    <?php
    echo $this->Html->scriptBlock('

');
    ?>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
            $('a.OrganizationsAdminViewControl').click(function () {
                $('#OrganizationsAdminViewPanel').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>