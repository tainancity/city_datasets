<div id="OrganizationsView">
    <h3><?php echo __('View 組織', true); ?></h3><hr />
    <div class="col-md-12">

        <div class="col-md-2">父項目</div>
        <div class="col-md-9"><?php
            if ($this->data['Organization']['parent_id']) {

                echo $this->data['Organization']['parent_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">名稱</div>
        <div class="col-md-9"><?php
            if ($this->data['Organization']['name']) {

                echo $this->data['Organization']['name'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">原始編號</div>
        <div class="col-md-9"><?php
            if ($this->data['Organization']['foreign_id']) {

                echo $this->data['Organization']['foreign_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">原始網址</div>
        <div class="col-md-9"><?php
            if ($this->data['Organization']['foreign_uri']) {

                echo $this->data['Organization']['foreign_uri'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">左</div>
        <div class="col-md-9"><?php
            if ($this->data['Organization']['lft']) {

                echo $this->data['Organization']['lft'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">右</div>
        <div class="col-md-9"><?php
            if ($this->data['Organization']['rght']) {

                echo $this->data['Organization']['rght'];
            }
            ?>&nbsp;
        </div>
    </div>
    <div class="btn-group">
        <?php echo $this->Html->link(__('組織 List', true), array('action' => 'index'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link(__('View Related 資料集', true), array('controller' => 'datasets', 'action' => 'index', 'Organization', $this->data['Organization']['id']), array('class' => 'btn btn-default OrganizationsAdminViewControl')); ?>
        <?php echo $this->Html->link(__('View Related 標籤', true), array('controller' => 'tags', 'action' => 'index', 'Organization', $this->data['Organization']['id']), array('class' => 'btn btn-default OrganizationsAdminViewControl')); ?>
    </div>
    <div id="OrganizationsViewPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
            $('a.OrganizationsViewControl').click(function () {
                $('#OrganizationsViewPanel').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>