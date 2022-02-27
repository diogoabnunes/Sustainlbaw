@extends('layouts.app', ['title' => 'Reset Password'])

@section('content')

    <main id= "conteudos" tabindex="0" class="container-xl main-height px-2 px-xl-0 py-5 d-flex flex-column justify-content-center align-items-center">
        <section class="login-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="/reset-password" method="POST">
                            {{ csrf_field() }}
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="pb-2 m-b-30">Refinir password</h3>
                                            <input type="hidden" name="email" value="{{$_GET['email']}}"/>
                                            <input type="hidden" name="token" value="{{$token}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password" class="form-control" name="password" value=""
                                            placeholder="Nova Password *" id="password" required autofocus>


                                        <div class="invalid-feedback">Falta preencher este campo.</div>
                                    </div>
                                    <div class="form-primary">
                                        <input type="password" class="form-control" name="password_confirmation"
                                            placeholder="Confirmar Password *" value="" id="password_confirmation" required>

                                        <div class="invalid-feedback">Falta preencher este campo.</div>
                                    </div>
                                    <div class="row">
                                        <div class="w-100">
                                            <input type="submit"
                                                class="btn btn-success w-100" name="submit" value="Atualizar" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
