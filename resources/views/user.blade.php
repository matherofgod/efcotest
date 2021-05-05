@extends('layouts.app')
@section('content')


<form method="POST" action="/user">
  @csrf
  <div class="row p-4">
    <div class="col-3">
      <div class="row justify-content-md-center ">
        <span class="border border-success" style="padding: .75rem; margin-bottom: 14px;">Вам положено {{$day[0]->days}} дней</span>
      </div>
      <div class="row">
        <label >Дата начала отпуска: </label>
        <input class="form-control" type="date" name="vacation"  placeholder="Дата" required>
      </div>
      <div class="row">
        <label >Дата окончания отпуска: </label>
        <input class="form-control" type="date" name="vacationlast" placeholder="Дата" required>
      </div>
      <div class="row top-buffer">
        <button  class="form-control btn btn-success" style="margin-top: 10px;">Сохранить</button>
      </div>
    </div>
</form>
  <div class="col-9">
    <form class="form-inline" method="GET">
      @csrf
      <div class="form-group mb-2">
        <input type="text" class="form-control" id="filterfio" name="filterfio" placeholder="ФИО" value="{{$filterfio}}">
      </div>
    <button type="submit" class="btn btn-default mb-2">Фильтр</button>
    </form>
    <table class="table">
      <thead class="table table-hover">
        <tr >
          <th scope="col">ФИО</th>
          <th scope="col">Статус</th>
          <th scope="col">Кол-во дней</th>
          <th scope="col">Дата начала</th>
          <th scope="col">Дата окончания</th>
          <th scope="col">Действие</th>
        </tr>                
      </thead>
      <tbody>
      @foreach($tbl as $table)
        <tr class="<?php
          if ($table->checked == "confirmed"):
            echo "bg-success";
          elseif ($table->checked == "rejected"):
            echo "bg-danger";
          else:
            echo "bg-warning";
          endif;
          ?>">
            <td>{{$table->name}}</td>
            <td>{{$table->checked === "expectation" ? "На согласовании" : ($table->checked === "rejected" ? "Отклонен" : "Согласован")}}</td>
            <td>{{abs(strtotime($table->vacation)-strtotime($table->vacationlast))/ (60 * 60 * 24)}}</td>
            <td>{{date('d.m.Y', strtotime($table->vacation))}}</td>
            <td>{{date('d.m.Y', strtotime($table->vacationlast))}}</td>
            <td>
              @if($table->id == Auth::id())           
              <button class="btn btn-warning" href="{{ route('user.edit', $table->id)}}" data-toggle="modal" data-target="#exampleModal" data-whatever="{{$table->grafs_id}}">Редактировать</button>
              @endif
            </td>
          </tr>
          @endforeach 
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Редактирование</h5>
      </div>
      <form action="{{route('user.update','edit')}}" method="post">
      		{{method_field('POST')}}
      		{{csrf_field()}}
      <div class="modal-body">
      
        <div class="row  justify-content-md-center">

        <div class="justify-content-md-center">
          <div class="form-group">
               <input type="hidden" class="form-control" name="recipientname" id="recipient-name" value="">
            
          </div>
            <div class="row">
                  <label >Дата начала отпуска: </label>
                  <input class="form-control" type="date" name="vacationupdate"  placeholder="Дата" required>
            </div>
            <div class="row">
                  <label >Дата окончания отпуска: </label>
                  <input class="form-control" type="date" name="vacationlastupdate" placeholder="Дата" required>
            </div>
            <div class="row top-buffer">
                <button type="submit" class="form-control btn btn-success" style="margin-top: 10px;">Сохранить</button>
            </div>
        </div>
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
    <!-- Modal -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Редактирование категории</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <form action="{{route('user.update','edit')}}" method="post">
      		{{method_field('POST')}}
      		{{csrf_field()}}
	      <div class="modal-body">
	      		<input type="hidden" name="tableid" id="tableid" value="">

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Выйти</button>
	        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
	      </div>
      </form>
    </div>
  </div>
</div>

@endsection
@push('script')
<script>
$('#exampleModal').on('show.bs.modal', function (event) {
   
   var button = $(event.relatedTarget) // Button that triggered the modal
   var recipient = button.data('whatever') // Extract info from data-* attributes
   var modal = $(this)
   modal.find('.modal-body input').val(recipient)
})
</script>
@endpush