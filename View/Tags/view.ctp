<style>
    .list{ list-style-type: none; margin: 5px; float: left; margin-right: 10px; background: #eee; padding: 5px; width: 200px;overflow:hidden;font-size:18px;}
    .list_dataset{background:#fff;border:1px solid #f1f1f1;padding:2px;margin:2px;font-size:15px;color: #1c94c4;}
    .list_dataset a{color: #1c94c4;}
</style>
<div id="TagsAdminView">
    <h3><?php
        echo implode(' > ', array(
            $this->Html->link('標籤', '/tags/index'),
            $this->data['Tag']['name'] . ' / ' . $this->data['Tag']['model'],
        ));
        ?></h3><hr />
    <h4>已標籤資料</h4>
    <?php
    foreach ($tags AS $tag) {
        echo '<div class="col-md-12">';
        echo '<b>' . $tag['Tag']['name'] . '</b><br />';
        foreach ($items as $item) {
            if (!empty($tag['Organization'][$item['Organization']['id']])) {
                $msg_datasets = '';
                foreach ($tag['Organization'][$item['Organization']['id']] AS $dataset) {
                    $msg_datasets.= '<div class="list_dataset">';
                    if (!empty($dataset['Dataset']['foreign_uri'])) {
                        $msg_datasets.= $this->Html->link($dataset['Dataset']['name'], $dataset['Dataset']['foreign_uri'], array('target' => '_blank'));
                    } else {
                        $msg_datasets.= $dataset['Dataset']['name'];
                    }
                    $msg_datasets.= '</div>';
                }
            } else {
                $msg_datasets = '<div class="list_dataset" style="color: red;"> ~ 無 ~ </div>';
            }
            echo '<div class="list">';
            if (!empty($item['Organization']['foreign_uri'])) {
                echo $this->Html->link($item['Organization']['name'], $item['Organization']['foreign_uri'], array('target' => '_blank'));
            } else {
                echo $item['Organization']['name'];
            }

            echo $msg_datasets;
            echo '</div>';
        }
        echo '</div>';
    }
    ?>
    <div class="clearfix"></div>
    <hr />
    <h4>未標籤資料</h4>
    <?php
    foreach ($items as $item) {
        $packages = 0;
        $msg_datasets = "";
        foreach ($item['Organization']['datasets'] as $dataset) {
            if (empty($dataset['Dataset']['name'])) {
                continue;
            }
            if (empty($dataset['LinksTag'])) {
                $msg_datasets.= '<div class="list_dataset">';
                if (!empty($dataset['Dataset']['foreign_uri'])) {
                    $msg_datasets.= $this->Html->link($dataset['Dataset']['name'], $dataset['Dataset']['foreign_uri'], array('target' => '_blank'));
                } else {
                    $msg_datasets.= $dataset['Dataset']['name'];
                }
                $msg_datasets.= '</div>';
            }
            $packages++;
        }
        echo '<div class="list">';
        if (!empty($item['Organization']['foreign_uri'])) {
            echo $this->Html->link($item['Organization']['name'] . "(" . $packages . ")", $item['Organization']['foreign_uri'], array('target' => '_blank'));
        } else {
            echo $item['Organization']['name'] . "(" . $packages . ")";
        }

        echo $msg_datasets;
        echo '</div>';
    }
    ?>
    <div class="clearfix"></div>
</div>