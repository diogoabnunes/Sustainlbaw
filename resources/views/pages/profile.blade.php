@extends('layouts.app', ['title' => 'Profile'])

@section('content')
    <main id="conteudos" tabindex="0"
        class="container-default main-height w-100 px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">
        @if (@isset($_GET['error']))
            <div class="alert alert-danger alert-dismissible fade show">
                <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <strong>Dados Inválidos...</strong>
            </div>
        @endif
        <div class="modal fade" id="modalDeleteProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="/user" class="modal-footer d-flex justify-content-end"
                        enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PATCH">
                        {{ csrf_field() }}
                        <div class="modal-header text-center">
                            <h4 class="modal-title w-100 font-weight-bold">Eliminar conta</h4>
                            <input type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        </div>
                        <div class="modal-body">
                            <p class="modal-title w-100 font-weight-bold fs-4">Tens a certeza que queres eliminar a tua
                                conta?
                            </p>
                            <input type="password" name="password" class="my-2 form-control"
                                placeholder="Digite a sua password *" required>
                            <p class="text-danger">Esta ação é irreversível!</p>

                        </div>


                        <input type="submit" class="btn btn-light" name="submit" data-dismiss="modal" value="Cancelar" />
                        <input type="submit" class="btn btn-danger" name="submit" id="modalButton" value="Eliminar" />


                    </form>

                </div>
            </div>
        </div>

        <div id="profile-page">
            <section class="profile-section form-page-new">
                <form method="post" action="/user" id="user" class="form-page-new w-100" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-12">
                            <h1 class="pb-4">Meu Perfil</h1>

                            <div
                                class="profile-image-upload d-flex flex-column justify-content-start align-items-start gap-4">
                                @if (@isset($user->image_path))
                                    <label id="upload-label" for="upload-photo"><i id="camera-icon"></i>
                                        <input type="file" name="image_path" value="{{ $user->image_path ?? '' }}"
                                            id="upload-photo" action=style="display:none" onchange="loadFile(event)" />
                                        <img id="display-photo" class="rounded-circle" src="{{ $user->getAdminAvatar() }}"
                                            alt="{{ $user->image_path }}">
                                    @else
                                        <label id="upload-label" for="upload-photo"><i id="camera-icon"
                                                class="fas fa-camera" style="display:none;"></i>
                                            <input type="file" name="image_path" value="{{ $user->image_path ?? '' }}"
                                                id="upload-photo" action=style="display:none" onchange="loadFile(event)" />
                                            <img id="display-photo" class="rounded-circle" src="{{ $user->getAvatar() }}"
                                                alt="Foto de Perfil" style="display:block;">
                                @endif


                            </div>
                        </div>

                        <script>
                            var loadFile = function(event) {
                                let output = document.getElementById('display-photo');
                                output.style.display = "block";
                                output.src = URL.createObjectURL(event.target.files[0]);
                                let camera = document.getElementById('camera-icon');
                                camera.style.display = "none";
                            };

                        </script>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <label for="profileName">Nome</label>
                                    <label class="text-danger">*</label>
                                    <input type="text" name="first_name" class="form-control" id="profileName"
                                        placeholder="Nome" required="true" value="{{ $user->first_name }}">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group ">
                                    <label for="profileSurname">Apelido</label>
                                    <label class="text-danger">*</label>
                                    <input type="text" name="last_name" class="form-control" id="profileSurname"
                                        placeholder="Apelido" required="true" value="{{ $user->last_name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="profileEmail">E-mail</label>
                                <label class="text-danger">*</label>
                                <input type="text" name="email" class="form-control" id="profileEmail" placeholder="E-mail"
                                    required="true" value="{{ $user->email }}" disabled>
                            </div>

                            <div class="row">
                                @if (@isset($_GET['UpdateUser']))
                                    @if ($_GET['UpdateUser'] == '" wrongPassword"')
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                            <strong>Erro!</strong> A palavra passe antiga não está correta... :(
                                        </div>
                                    @elseif ($_GET['UpdateUser'] == '"wrongNewPassword"')
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                            <strong>Erro!</strong> A palavra passe nova não coincide com a
                                            confirmação... :(
                                        </div>
                                    @elseif ($_GET['UpdateUser'] == '"newPasswordNotValid"')
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                            <strong>Erro!</strong> A palavra passe nova não tem no mínimo 6
                                            caracteres... :(
                                        </div>
                                    @endif
                                @endif

                                <label for="old_password">Mudar palavra-passe</label>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group form-primary">
                                    <input type="password" name="actual_password" class="form-control" name="old_password"
                                        placeholder="Palavra-passe actual" value="" id="old_password" required>
                                    <div class="invalid-feedback">Falta preencher este campo.</div>
                                </div>

                                <label for="password">Nova palavra-passe</label>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group form-primary">
                                    <input type="password" name="new_password1" class="form-control" name="password"
                                        placeholder="Nova palavra-passe" value="" id="password">
                                    <div class="invalid-feedback">Falta preencher este campo.</div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group form-primary">
                                    <input type="password" name="new_password2" class="form-control" name="password_confirm"
                                        placeholder="Confirmar nova palavra-passe" value="" id="password_confirm">
                                    <div class="invalid-feedback">Falta preencher este campo.</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mt-4 r col-lg-8 col-md-8 col-sm-12">
                                    <button type="submit" class="btn btn-success">Atualizar</button>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <button type="submit" class="btn-delete-profile btn btn-danger mt-4 float-end"
                                        data-toggle="modal" data-id="{{ $user->user_id }}"
                                        data-target="#modalDeleteProfile" name="submit">
                                        <i class="fas fa-user-times"></i> &nbsp; Apagar conta</button>
                                </div>
                            </div>

                        </div>
                </form>
            </section>
        </div>
    </main>
    <script src="../js/app.js"> </script>
    <script>
        // let selectedBtn;
        // let btns = document.querySelectorAll('.btn-delete-profile');

        // for (let btn of btns) {
        //     btn.addEventListener('click', () => {
        //         selectedBtn = btn;
        //     })
        // }

        // function deleteProfile() {
        //     sendAjaxRequest('put', '/user', {
        //         user_id: selectedBtn.getAttribute('data-id')
        //     }, deleteProfileHandler);
        // }


        // function deleteProfileHandler() {
        //     let data = JSON.parse(this.responseText);
        //     closeOneModal("modalDeleteProfile");
        //     let alert = document.createElement('div');
        //     alert.classList.add('alert');
        //     alert.classList.add('alert-danger');
        //     alert.classList.add('alert-dismissible');
        //     alert.classList.add('fade');
        //     alert.classList.add('show');
        //     alert.setAttribute('role', 'alert');
        //     alert.innerHTML = '<input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">';
        //     alert.innerHTML += 'Perfil Eliminado.';
        //     let main = document.getElementsByTagName('main')[0];
        // }

    </script>
@endsection
