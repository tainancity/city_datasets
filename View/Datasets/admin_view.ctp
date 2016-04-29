<div id="DatasetsAdminView">
    <h3><?php echo __('View 資料集', true); ?></h3><hr />
    <div class="col-md-12">
        <div class="col-md-2">組織</div>
        <div class="col-md-9">&nbsp;<?php
            if (empty($this->data['Organization']['id'])) {
                echo '--';
            } else {
                echo $this->Html->link($this->data['Organization']['id'], array(
                    'controller' => 'organizations',
                    'action' => 'view',
                    $this->data['Organization']['id']
                ));
            }
            ?></div>

        <div class="col-md-2">父項目</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['parent_id']) {

                echo $this->data['Dataset']['parent_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">名稱</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['name']) {

                echo $this->data['Dataset']['name'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">原始編號</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['foreign_id']) {

                echo $this->data['Dataset']['foreign_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">原始網址</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['foreign_uri']) {

                echo $this->data['Dataset']['foreign_uri'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">建立時間</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['created']) {

                echo $this->data['Dataset']['created'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">更新時間</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['modified']) {

                echo $this->data['Dataset']['modified'];
            }
            ?>&nbsp;
        </div>
    </div>
    <hr />
    <div class="btn-group">
        <?php echo $this->Html->link('檢視標籤', array('controller' => 'tags', 'action' => 'index', 'Dataset', $this->data['Dataset']['id']), array('class' => 'btn btn-default DatasetsAdminViewControl')); ?>
        <?php echo $this->Html->link('設定標籤', array('controller' => 'tags', 'action' => 'index', 'Dataset', $this->data['Dataset']['id'], 'set'), array('class' => 'btn btn-default DatasetsAdminViewControl')); ?>
    </div>
    <div id="DatasetsAdminViewPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
            $('a.DatasetsAdminViewControl').click(function () {
                $('#DatasetsAdminViewPanel').load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>