<div id="OrganizationsAdminView">
    <h3>檢視地方縣市</h3><hr />
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
        <?php echo $this->Html->link('相關資料集', array('controller' => 'datasets', 'action' => 'index', 'Organization', $this->data['Organization']['id']), array('class' => 'btn btn-default OrganizationsAdminViewControl')); ?>
        <?php echo $this->Html->link('相關標籤', array('controller' => 'tags', 'action' => 'index', 'Organization', $this->data['Organization']['id']), array('class' => 'btn btn-default OrganizationsAdminViewControl')); ?>
        <?php echo $this->Html->link('設定標籤', array('controller' => 'tags', 'action' => 'index', 'Organization', $this->data['Organization']['id'], 'set'), array('class' => 'btn btn-default OrganizationsAdminViewControl')); ?>
    </div>
    <div id="OrganizationsAdminViewPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
            $('a.OrganizationsAdminViewControl').click(function () {
                $('#OrganizationsAdminViewPanel').load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>