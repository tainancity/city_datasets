<div id="DatasetsView">
    <h3><?php echo __('View 資料集', true); ?></h3><hr />
    <div class="col-md-12">
        <div class="col-md-2">組織</div>
        <div class="col-md-9"><?php
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
        <div class="col-md-9"><?php
            if ($this->data['Dataset']['parent_id']) {

                echo $this->data['Dataset']['parent_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">名稱</div>
        <div class="col-md-9"><?php
            if ($this->data['Dataset']['name']) {

                echo $this->data['Dataset']['name'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">原始編號</div>
        <div class="col-md-9"><?php
            if ($this->data['Dataset']['foreign_id']) {

                echo $this->data['Dataset']['foreign_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">原始網址</div>
        <div class="col-md-9"><?php
            if ($this->data['Dataset']['foreign_uri']) {

                echo $this->data['Dataset']['foreign_uri'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">左</div>
        <div class="col-md-9"><?php
            if ($this->data['Dataset']['lft']) {

                echo $this->data['Dataset']['lft'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">右</div>
        <div class="col-md-9"><?php
            if ($this->data['Dataset']['rght']) {

                echo $this->data['Dataset']['rght'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">建立時間</div>
        <div class="col-md-9"><?php
            if ($this->data['Dataset']['created']) {

                echo $this->data['Dataset']['created'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">更新時間</div>
        <div class="col-md-9"><?php
            if ($this->data['Dataset']['modified']) {

                echo $this->data['Dataset']['modified'];
            }
            ?>&nbsp;
        </div>
    </div>
    <div class="btn-group">
        <?php echo $this->Html->link(__('資料集 List', true), array('action' => 'index'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link(__('View Related 標籤', true), array('controller' => 'tags', 'action' => 'index', 'Dataset', $this->data['Dataset']['id']), array('class' => 'btn btn-default DatasetsAdminViewControl')); ?>
    </div>
    <div id="DatasetsViewPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
            $('a.DatasetsViewControl').click(function () {
                $('#DatasetsViewPanel').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>