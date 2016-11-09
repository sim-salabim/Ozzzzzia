<?php
use yii\helpers\Url;
?>

<div id="loadcontent-container" style="display: none"></div>

<div id="lang-table">


    <div class="well">
        <button class="btn btn-primary loadcontent"
                data-link="">
            <i class="fa fa-fw -square -circle fa-plus-square"></i>
            Создать новый пункт
        </button>
    </div>



<div class="box">
    <div class="box-header">
        <h3 class="box-title">Языки</h3>

        <div class="box-tools">
          <div class="input-group">
              <input name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search" type="text">
              <div class="input-group-btn">
                  <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
              </div>
          </div>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <thead>
          <tr>
            <th>ID</th>
            <th>Код</th>
            <th>Действие</th>
          </tr>
          </thead>
          <tbody>
            <?php foreach ($languages as $lang) : ?>
              <tr>
                <td><?php echo $lang->id?>
                </td>
                <td><?php echo $lang->code?>
                    <?= backend\helpers\ActiveLabel::status($lang->active, [
                        'active' => 'используется',
                        'inactive' => 'не используется'
                    ])?>
                </td>
                <td>
                    <span data-placement="top" data-toggle="tooltip" title="Редактировать">
                        <button class="btn btn-primary btn-xs loadcontent"
                                data-link="<?= Url::toRoute(['edit-category','id' => $lang->id])?>">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                    </span>
                    <span data-placement="top" data-toggle="tooltip" title="Удалить">
                        <button class="btn btn-danger btn-xs senddata"
                                data-link="<?= Url::toRoute(['delete','id' => $lang->id])?>">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                    </span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&raquo;</a></li>
            </ul>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>

</div>