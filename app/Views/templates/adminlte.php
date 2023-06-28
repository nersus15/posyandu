  <!-- Content Wrapper. Contains page content -->
  <?php
    if (!isset($navbarOpt))
        $navbarOpt = [];

    if (!isset($sidebarOpt))
        $sidebarOpt = [];

    if (!isset($dataHeader))
        $dataHeader = [];

    if (!isset($dataFooter))
        $dataFooter = [];
    
    if(!isset($contents))
        $contents = [];

    echo $this->setData($dataHeader)->include('components/header', $dataHeader);
    echo $this->setData($navbarOpt)->include('components/navbar', $navbarOpt);
    echo $this->setData($sidebarOpt)->include('components/sidebar', $sidebarOpt);
    ?>
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1><?= $dataHeader['title'] ?? null ?></h1>
                  </div>
                  <!-- <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">Blank Page</li>
                      </ol>
                  </div> -->
              </div>
          </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

          <!-- Default box -->
            <?php foreach($contents as $key => $content ):?>
                <?= $this->setData(array_merge($content['data'], ['idContent' => $key]))->include($content['view'], array_merge($content['data'], ['idContent' => $key])); ?>
            <?php endforeach ?>
          <!-- /.card -->

      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
    echo $this->setData($dataFooter)->include('components/footer', $dataFooter);
