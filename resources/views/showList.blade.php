@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      
    </tr>
  </thead>
  <tbody>
      @for($i = 0; $i < count($legislators); $i++) 
    <tr>
      <th scope="row">1</th>
      <td>{{$legislators[$i][0]}}</td>
      <td>{{$legislators[$i][1]}}</td>
      <td>{{$legislators[$i][2]}}</td>
    </tr>
    @endfor
   
  </tbody>
</table>
        </div>
    </div>
</div>
@endsection