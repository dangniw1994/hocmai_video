@extends('common.default')
@section('content')
<div class="col-md-12 col-sm-12  ">
  <div class="x_panel">
    <div class="x_title">
      <h2 class="navbar-left">Thêm mới && <a class="btn btn-danger" href="{{ action('VideoController@index') }}"><i class="fa fa-back"></i> Trở lại</a></h2>
      <ul class="nav navbar-right panel_toolbox">
        <li>
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <br>
      {{ Form::open(array('method'=>'POST', 'action' => array('VideoController@store'),'class'=>'form-horizontal form-label-left')) }}
      <div class="form-group row">
        <div class="col-md-12 col-sm-12  form-group has-feedback">
          {{ Form::text('url', null, array('class' => 'form-control has-feedback-left','placeholder'=>'url')) }}
          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-12 col-sm-12  form-group has-feedback">
          {{ Form::text('name', null, array('class' => 'form-control has-feedback-left','placeholder'=>'tiêu đề')) }}
          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-md-3 col-sm-3  form-group has-feedback">
            <label class="control-label col-md-4 col-sm-4">Nguồn video</label>
            <div class="col-md-10 col-sm-10 ">
              <select name="source" id="source">
                <option value="0">Tất cả</option>
                <option value="1">Google Drive</option>
                <option value="2">Youtobe</option>
                <option value="3">HocMai</option>
              </select>
            </div>
        </div>
        <div class="col-md-3 col-sm-3  form-group has-feedback">
            <label class="control-label col-md-3 col-sm-3">Khối</label>
            <div class="col-md-10 col-sm-10 ">
              {{ Form::select('schoolbock_id', getListKhoi(), array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-md-3 col-sm-3  form-group has-feedback">
            <label class="control-label col-md-3 col-sm-3">Lớp </label>
            <div class="col-md-10 col-sm-10 ">
              {{ Form::select('class_id', getListClass(), array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-md-3 col-sm-3  form-group has-feedback">
            <label class="control-label col-md-4 col-sm-4">Môn</label>
            <div class="col-md-10 col-sm-10 ">
              {{ Form::select('schoolSubject_id', getListMon(), array('class' => 'form-control')) }}
            </div>
        </div>
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