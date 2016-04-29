<div id="DatasetsIndex">
    <h2><?php echo __('資料集', true); ?></h2>
    <div class="btn-group">
    </div>
    <p>
        <?php
        $url = array();

        if (!empty($foreignId) && !empty($foreignModel)) {
            $url = array($foreignModel, $foreignId);
        }

        echo $this->Paginator->counter(array(
            'format' => __('第 {:page} 頁 / 共 {:pages} 頁，總數： {:count}  筆')
        ));
        ?></p>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="DatasetsIndexTable">
        <thead>
            <tr>
                <?php if (empty($scope['Dataset.organization_id'])): ?>
                    <th><?php echo $this->Paginator->sort('Dataset.organization_id', '組織', array('url' => $url)); ?></th>
                <?php endif; ?>

                <th><?php echo $this->Paginator->sort('Dataset.parent_id', '父項目', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.name', '名稱', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.foreign_id', '原始編號', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.foreign_uri', '原始網址', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Dataset.modified', '更新時間', array('url' => $url)); ?></th>
                <th class="actions">操作</th>
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
                    <?php if (empty($scope['Dataset.organization_id'])): ?>
                        <td><?php
                            if (empty($item['Organization']['id'])) {
                                echo '--';
                            } else {
                                echo $this->Html->link($item['Organization']['id'], array(
                                    'controller' => 'organizations',
                                    'action' => 'view',
                                    $item['Organization']['id']
                                ));
                            }
                            ?></td>
                    <?php endif; ?>

                    <td><?php
                        echo $item['Dataset']['parent_id'];
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['name'];
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['foreign_id'];
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['foreign_uri'];
                        ?></td>
                    <td><?php
                        echo $item['Dataset']['modified'];
                        ?></td>
                    <td>
                        <div class="btn-group">
                            <?php echo $this->Html->link('檢視', array('action' => 'view', $item['Dataset']['id']), array('class' => 'btn btn-default DatasetsIndexControl')); ?>
                        </div>
                    </td>
                </tr>
            <?php }; // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="DatasetsIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
            $('#DatasetsIndexTable th a, div.paging a, a.DatasetsIndexControl').click(function () {
                $('#DatasetsIndex').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>