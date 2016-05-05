<div id="TagsIndex">
    <h2>標籤</h2>
    <?php
    foreach ($items as $item) {
        echo $this->Html->link("{$item['Tag']['name']} ({$item[0]['count']})", '/tags/view/' . $item['Tag']['id'], array('class' => 'btn btn-default'));
    }
    ?>
</div>