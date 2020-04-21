@extends('common.default')
@section('content')
<div class="col-md-12 col-sm-12  ">
  <div class="x_panel">
    <h2>Sửa tên: {{ $header->name }} </h2>
    <div class="x_title">
      <a href="{{ action('HeaderController@index') }}" class="btn btn-danger">Trở lại</a>
      <ul class="nav navbar-right panel_toolbox">
        <li>
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <br>
      {{ Form::open(array('action' => array('HeaderController@update', $header->id), 'method' => "PUT", 'files' => true)) }}
      <div class="form-group row">
        <div class="col-md-12 col-sm-12  ">
          <label class="control-label col-md-2 col-sm-2">Mô tả</label>
          <div class="col-md-11 col-sm-11">
            {{ Form::textarea('desc', $header->desc, array('class' => 'form-control','id'=>'editor1')) }}
          </div>
        </div>
      </div>
      <div class="row form-group">
        <h2>Thời gian hiển thị</h2>
        <div class="col-lg-12">
          <div class="col-lg-3 col-md-3 float-left">
            <label>Từ giờ</label>
            <div class="datetimepicker3" class="input-append">
              <input data-format="hh:mm" type="text" name="start_time" value="{{$header->start_time}}"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 ">
            <label>Đến giờ</label>
            <div class="datetimepicker4" class="input-append">
              <input data-format="hh:mm" type="text" name="end_time" value="{{$header->end_time}}"></input>
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>
          </div>
          <div class="col-md-6 col-lg-6 ">
            <label class="control-label col-md-2 col-sm-2">Trạng thái</label>
            <div class="col-md-10 col-sm-10">
              <select class="form-control" name="status">
                <option value="0">deactivate</option>
                <option value="1">active</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-6 col-lg-6 ">
          <label class="control-label col-md-2 col-sm-2">Ảnh đại diện</label>
          <div class="col-md-11 col-sm-11">
            <input type="file" name="image" class="form-control"><br>
            @if($header->image)
                <img src="{{$header->image }}" width="150px" height="auto"  />
            @endif
          </div>
        </div>
        
      </div>
      
      <div class="form-group row">
          {{ Form::submit('Submit', array('class' => 'btn btn-success')) }}
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
@stop
