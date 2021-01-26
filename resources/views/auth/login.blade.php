@extends('layout')
@section('content')
  <form method="POST" action="{{ route('login') }}">
    @csrf



    <div class="form-group">
      <label>E-mail</label>
      <input name="email" value="{{ old('email') }}" required 
      class="form-control  {{$errors->has('email') ? 'is-invalid':''}}">

      @if($errors->has('email'))
      <span class="invalid-feedback">
      <strong>{{$errors->first('email')}}</strong>    
    </span>
      @endif
    </div>

    <div class="form-group">
      <label>Password</label>
      <input name="password" required  type="password"
      class="form-control {{$errors->has('password') ? 'is-invalid':''}}">

      @if($errors->has('password'))
      <span class="invalid-feedback">
      <strong>{{$errors->first('password')}}</strong>    
    </span>
      @endif
    </div>


<div class="form-group" > 
<div class="form-check">

<input type="checkbox" name="remember" id="" class="form-check-input" value="{{old('remember')? 'checked':''}}">

<label for="" class="form-check-table" for="remember"> Remeber me</label>

</div>

</div>
    <button type="submit" class="btn btn-primary btn-block">login!</button>
  </form>
@endsection('content')