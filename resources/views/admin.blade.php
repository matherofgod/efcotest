@extends('layouts.app')
@section('content')

        <div class="col-12">
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
                        <div class="flex">
                        <form method="POST" action="/admin">
                        @csrf
                        <input type="hidden" name="dataid" value="{{$table->id}}">
                        <button type="submit" class="btn btn-success">Согласовать</button>
                        </form>
                        </div>
                        <div>
                        <form method="POST" action="/admin">
                        @csrf
                        <input type="hidden" name="dataiddel" value="{{$table->id}}">
                        <button type="submit" class="btn btn-danger">Отклонить</button>
                        </form>
                        </div>
                        </td>
                    </tr>
                @endforeach 
                </tbody>
            </table>
        </div>
@endsection