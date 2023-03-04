<?php
$data=[
    'pageTitle'=>'Thêm mới blog'
];
layout('header', 'admin',$data);
layout('sidebar', 'admin',$data);
layout('breadcrumb','admin',$data);
?>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="">
                <div class="form-group">
                    <label for=""> Tiêu đề</label>
                    <input type="text" class="form-control" name="title" placeholder="Tiêu đề bài viết...">
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
<?php
layout('footer', 'admin',$data);


