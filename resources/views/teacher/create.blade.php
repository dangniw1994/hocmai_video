@extends('common.default')
@section('content')
<div class="col-md-12 col-sm-12  ">
  <div class="x_panel">
    <h2>Thêm mới Giáo viên</h2>
    <div class="x_title">
      <a href="{{ action('TeacherController@index') }}" class="btn btn-danger" title="Trở lại">Trở lại</a>
      <ul class="nav navbar-right panel_toolbox">
        <li>
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <br>
      {{ Form::open(array('method'=>'POST','files'=>true, 'action' => array('TeacherController@store'),'class'=>'form-horizontal form-label-left')) }}
      <div class="form-group row">
        <div class="col-md-6 col-sm-6 col-lg-6">
            <label class="col-md-4 col-sm-4 col-lg-4">Tên giáo viên</label>
            <div class="col-md-11 col-sm-11 "> 
              <input type="text" class="form-control" required data-errormessage-value-missing="Please input something" name="name" id="name">
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <label>ảnh đại diện</label>
            <div class="multiselect_div">
            <input type="file" class="form-control" required data-errormessage-value-missing="Please input something" name="avatar" id="avatar">
            </div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-2 col-sm-2 col-lg-4">Mô tả</label>
        <div class="col-md-11 col-sm-11 ">
          <textarea name="desc" id="editor1"required data-errormessage-value-missing="Please input something"></textarea>
      </div>
      <div class="form-group row">
          {{ Form::submit('Submit', array('class' => 'btn btn-success')) }}
          {{ Form::reset('Reset', array('class' => 'btn btn-info')) }}
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
@stop