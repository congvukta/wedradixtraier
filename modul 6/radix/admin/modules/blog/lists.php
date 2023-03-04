<?php
$data=[
    'pageTitle'=>'Danh sách blog'
];
layout('header', 'admin',$data);
layout('sidebar', 'admin',$data);
layout('breadcrumb','admin',$data);
?>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th width="5%">STT</th>
                    <th>Tiêu đề</th>
                    <th>Danh mục</th>
                    <th>Thời gian</th>
                    <th width="5%">Sửa</th>
                    <th width="5%">Xóa</th>
                </tr>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                </tbody>
                </thead>
            </table>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
<?php
layout('footer', 'admin',$data);

