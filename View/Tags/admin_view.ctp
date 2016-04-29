<div id="TagsAdminView">
    <h3><?php echo __('View 標籤', true); ?></h3><hr />
    <div class="col-md-12">

        <div class="col-md-2">父項目</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Tag']['parent_id']) {

                echo $this->data['Tag']['parent_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">名稱</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Tag']['name']) {

                echo $this->data['Tag']['name'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">Model</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Tag']['model']) {

                echo $this->data['Tag']['model'];
            }
            ?>&nbsp;
        </div>
    </div>
    <hr />
    <div id="TagsAdminViewPanel"></div>
    <?php
    echo $this->Html->scriptBlock('

');
    ?>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
            $('a.TagsAdminViewControl').click(function () {
                $('#TagsAdminViewPanel').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>