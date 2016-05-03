<div id="TagsAdminView">
    <h3><?php
        echo implode(' > ', array(
            $this->Html->link('標籤', '/admin/tags/index'),
            $this->data['Tag']['name'] . ' / ' . $this->data['Tag']['model'],
        ));
        ?></h3><hr />
    <table class="table table-bordered" id="TagsAdminIndexTable">
        <thead>
            <tr>
                <th>地方縣市</th>
                <th>資料集</th>
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
                        echo $this->Html->link($item['Organization']['name'], '/admin/organizations/view/' . $item['Dataset']['organization_id']);
                        ?></td>
                    <td><?php
                        echo $this->Html->link($item['Dataset']['name'], '/admin/datasets/view/' . $item['Dataset']['id']);
                        ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" class="removeTag btn btn-default" data-tag-id="<?php echo $this->data['Tag']['id']; ?>" data-id="<?php echo $item['Dataset']['id']; ?>">移除</a>
                        </div>
                    </td>
                </tr>
            <?php } // End of foreach ($items as $item) {   ?>
        </tbody>
    </table>
</div>
<script>
    var tagSetUrl = '<?php echo $this->Html->url('/admin/tags/habtmSet/Dataset/'); ?>';
    var clickedLine = null;
    $(function () {
        $('a.removeTag').click(function () {
            var organizationId = $(this).attr('data-id');
            var tagId = $(this).attr('data-tag-id');
            clickedLine = $(this).parents('tr');
            $.get(tagSetUrl + organizationId + '/' + tagId + '/off', {}, function () {
                clickedLine.remove();
            });
            return false;
        });
    })
</script>