
@extends('common.default')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <small> <a href="{{action('ManagerAppController@create')}}"><i class="fa fa-plus-circle"></i> Thêm mới</a></small>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
          <div id="search_header" class="col-md-12">
            {{ Form::open(array('method'=>'get', 'action' => array('ManagerAppController@index','multiple' => 'multiple'))) }}
            <div class="col-md-2">
              {{ Form::select('os_id', getApp(),null, array('class' => 'form-control','id'=>'os_id_select' )) }}
            </div>
            <div class="col-md-2">
              <select name="app_version" id="app_version" class="form-control">
                <option value="">Tất cả</option>
                @foreach(getVersion() as $item)
                  <option value="{{ $item->app_version}}" >{{ $item->app_version }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
                  {{ Form::select('status', getStatus(),old('status'), array('class' => 'form-control','id'=>'os_id_select' )) }}
            </div>
            <div class="col-md-2">
                {{ Form::submit('tìm kiếm', array('class' => 'btn btn-success')) }}
                <a href="{{action('ManagerAppController@index')}}" class="btn btn-info">Clear</a>
            </div>
            {{ Form::close() }}
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card-box table-responsive">
              <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>Stt</th>
                    <th>Id</th>
                    <th>App Id</th>
                    <th>Os Id</th>
                    <th>App version</th>
                    <th>Status</th>
                    <th>adjust_event</th>
                    <th width="280px">Hành động</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1 ?>
                  @foreach($data as $hocmaiApp)
                  <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $hocmaiApp->id }}</td>
                    <td>{{ $hocmaiApp->app_id }}</td>
                    <td>{{ $hocmaiApp->os_id == 1 ? "Ios" :"Android" }}</td>
                    <td>{{ $hocmaiApp->app_version }}</td>
                    <td>{{ getNameStatusAppVersion($hocmaiApp->status) }}</td>
                    <td>{{ $hocmaiApp->adjust_event }}</td>
                    <td>
                        <form action="{{ action('ManagerAppController@destroy',$hocmaiApp->id) }}" method="POST">
                        <a href="{{ action('ManagerAppController@show',$hocmaiApp->id) }}"><i class="fa fa-eye" style="color:#ff00b4"></i>xem chi tiết |</a>
                        <a href="{{ action('ManagerAppController@edit', $hocmaiApp->id) }}" title="Sửa"><i class="fa fa-edit" style="color:blue"></i> Sửa |</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit"><a onclick="return confirm('Bạn có chắc chắn muốn xóa?');">
                          <i class="fa fa-trash" style="color:blue"></i>Xóa
                          </a></button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @stop