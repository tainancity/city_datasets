<div id="DatasetsAdminView">
    <h3>資料集::<?php echo $this->data['Dataset']['name']; ?></h3><hr />
    <div class="col-md-12">
        <div class="col-md-2">地方縣市</div>
        <div class="col-md-9">&nbsp;<?php
            if (empty($this->data['Organization']['id'])) {
                echo '--';
            } else {
                echo $this->Html->link($this->data['Organization']['name'], array(
                    'controller' => 'organizations',
                    'action' => 'view',
                    $this->data['Organization']['id']
                        ), array('target' => '_blank'));
            }
            ?></div>

        <div class="col-md-2">父項目</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['parent_id']) {

                echo $this->data['Dataset']['parent_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">名稱</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['name']) {

                echo $this->data['Dataset']['name'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">原始編號</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['foreign_id']) {

                echo $this->data['Dataset']['foreign_id'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">原始網址</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['foreign_uri']) {

                echo $this->data['Dataset']['foreign_uri'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">建立時間</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['created']) {

                echo $this->data['Dataset']['created'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">更新時間</div>
        <div class="col-md-9">&nbsp;<?php
            if ($this->data['Dataset']['modified']) {

                echo $this->data['Dataset']['modified'];
            }
            ?>&nbsp;
        </div>
        <div class="col-md-2">標籤</div>
        <div class="col-md-9">&nbsp;<?php
            if (!empty($this->data['Tag'])) {
                foreach ($this->data['Tag'] AS $tag) {
                    echo $this->Html->link($tag['name'], '/admin/tags/view/' . $tag['id'], array('class' => 'btn btn-default'));
                    echo ' &nbsp; <a href="#" class="" data-id="' . "{$tag['LinksTag']['model']}/{$tag['LinksTag']['foreign_id']}/{$tag['LinksTag']['tag_id']}" . '">[x]</a>';
                }
            }
            ?>&nbsp;
        </div>
    </div>
    <hr />
    <script type="text/javascript">
        //<![CDATA[
        $(function () {

        });
        //]]>
    </script>
</div>