<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="">
                    <ul class="nav nav-tabs card-header-tabs" id="bologna-list" role="tablist">
                        <?php foreach ($contents as $k => $content) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $content['active'] ? 'active' : '' ?>" href="#<?= str_replace(' ', '-', $k) ?>" role="tab" aria-controls="<?= str_replace(' ', '-', $k) ?>" aria-selected="true"><?= $k . ' '. ($content['badge'] ?? null) ?></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div class="card-body" style="overflow-x: scroll;">
                    <div class="tab-content mt-3">
                        <?php foreach ($contents as $k => $content) : ?>
                            <div class="tab-pane <?= $content['active'] ? 'active' : '' ?>" id="<?= str_replace(' ', '-', $k) ?>" role="tabpanel">
                                <?= $this->setData(array_merge($content['data'], ['cardless' => true]))->include($content['view']); ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#bologna-list a').on('click', function(e) {
            e.preventDefault()
            $(this).tab('show')
        })
    });
</script>