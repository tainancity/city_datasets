<div id="TagsIndex">
    <h2><?php echo __('標籤', true); ?></h2>
    <div class="btn-group">
    </div>
    <p>
        <?php
        $url = array();

        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?></p>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="TagsIndexTable">
        <thead>
            <tr>

                <th><?php echo $this->Paginator->sort('Tag.parent_id', '父項目', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Tag.name', '名稱', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Tag.model', 'Model', array('url' => $url)); ?></th>
                <th class="actions"><?php echo __('Action', true); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($items as $item) {
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class; ?>>

                    <td><?php
                        echo $item['Tag']['parent_id'];
                        ?></td>
                    <td><?php
                        echo $item['Tag']['name'];
                        ?></td>
                    <td><?php
                        echo $item['Tag']['model'];
                        ?></td>
                    <td>
                        <div class="btn-group">
                            <?php echo $this->Html->link(__('View', true), array('action' => 'view', $item['Tag']['id']), array('class' => 'btn btn-default TagsIndexControl')); ?>
                        </div>
                    </td>
                </tr>
            <?php }; // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="TagsIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
            $('#TagsIndexTable th a, div.paging a, a.TagsIndexControl').click(function () {
                $('#TagsIndex').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>