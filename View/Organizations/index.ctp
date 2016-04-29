<div id="OrganizationsIndex">
    <h2><?php echo __('組織', true); ?></h2>
    <div class="btn-group">
    </div>
    <p>
        <?php
        $url = array();

        echo $this->Paginator->counter(array(
            'format' => '第 {:page} 頁 / 共 {:pages} 頁，總數： {:count}  筆'
        ));
        ?></p>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="OrganizationsIndexTable">
        <thead>
            <tr>

                <th><?php echo $this->Paginator->sort('Organization.parent_id', '父項目', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Organization.name', '名稱', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Organization.foreign_id', '原始編號', array('url' => $url)); ?></th>
                <th><?php echo $this->Paginator->sort('Organization.foreign_uri', '原始網址', array('url' => $url)); ?></th>
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

                    <td><?php
                        echo $item['Organization']['parent_id'];
                        ?></td>
                    <td><?php
                        echo $item['Organization']['name'];
                        ?></td>
                    <td><?php
                        echo $item['Organization']['foreign_id'];
                        ?></td>
                    <td><?php
                        echo $item['Organization']['foreign_uri'];
                        ?></td>
                    <td>
                        <div class="btn-group">
                            <?php echo $this->Html->link('檢視', array('action' => 'view', $item['Organization']['id']), array('class' => 'btn btn-default OrganizationsIndexControl')); ?>
                        </div>
                    </td>
                </tr>
            <?php }; // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="OrganizationsIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
            $('#OrganizationsIndexTable th a, div.paging a, a.OrganizationsIndexControl').click(function () {
                $('#OrganizationsIndex').parent().load(this.href);
                return false;
            });
        });
        //]]>
    </script>
</div>