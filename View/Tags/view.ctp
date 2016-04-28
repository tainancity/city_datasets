<div id="TagsView">
    <h3><?php echo __('View 標籤', true); ?></h3><hr />
    <div class="col-md-12">

        <div class="col-md-2">父項目</div>
        <div class="col-md-9"><?php
            if ($this->data['Tag']['parent_id']) {

                echo $this->data['Tag']['parent_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">名稱</div>
        <div class="col-md-9"><?php
            if ($this->data['Tag']['name']) {

                echo $this->data['Tag']['name'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">Model</div>
        <div class="col-md-9"><?php
            if ($this->data['Tag']['model']) {

                echo $this->data['Tag']['model'];
            }
            ?>&nbsp;
        </div>
    </div>
    <div class="btn-group">
        <?php echo $this->Html->link(__('標籤 List', true), array('action' => 'index'), array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link(__('View Related 資料集', true), array('controller' => 'datasets', 'action' => 'index', 'Tag', $this->data['Tag']['id']), array('class' => 'btn btn-default TagsAdminViewControl')); ?>
        <?php echo $this->Html->link(__('View Related 組織', true), array('controller' => 'organizations', 'action' => 'index', 'Tag', $this->data['Tag']['id']), array('class' => 'btn btn-default TagsAdminViewControl')); ?>
    </div>
    <div id="TagsViewPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
            $('a.TagsViewControl').click(function () {
                $('#TagsViewPanel').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>