@extends('layouts.app', ['title' => 'Administration'])

@section('content')
    <main id="conteudos" tabindex="0"
        class="w-100 h-100 container-default px-2 px-xl-0 py-5 d-flex flex-column justify-content-start align-items-start">

        <h1 class="pb-2">Gestão de Utilizadores</h1>

        <form id="search-form" method="get" action="{{ route('searchUsers') }}">

            <div class="d-flex flex-row mb-4">
                <input id="search-input" type="search" name="keywords" id="form1" class="form-control"
                    placeholder="Pesquisar" />
                <button id="search-button" type="submit" form="search-form" value="Search"
                    class="btn btn-secondary rounded-0 rounded-end">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <div class="modal fade" id="modalDeleteUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Tens a certeza que queres eliminar este
                                    utilizador?</h4>
                                <input type="button" data-dismiss="modal" class="btn-close" data-dismiss="modal"
                                    aria-label="Close">
                            </div>
                            <div class="modal-footer d-flex justify-content-end">
                                <input type="submit" data-dismiss="modal" class="btn btn-light" name="submit"
                                    value="Cancelar" />
                                <input type="submit" onclick="deleteUser()" class="btn btn-danger" name="submit"
                                    id="modalButton" value="Eliminar" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade ui" id="modalChangeUserRole" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Tens a certeza que pretende mudar o cargo
                                    deste utilizador?</h4>
                                <input type="button" data-dismiss="modal" class="btn-close" data-dismiss="modal"
                                    aria-label="Close">
                            </div>
                            <div class="modal-footer d-flex justify-content-end">
                                <input type="submit" data-dismiss="modal" class="btn btn-light" name="submit"
                                    value="Cancelar" />
                                <input type="submit" onclick="confirmRole()" class="btn btn-primary" name="submit"
                                    id="modalButton" value="Guardar" />
                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($users as $user)
                    @include('partials.admin.user_row', ['user' => $user])
                @endforeach
            </tbody>
        </table>

    </main>
    <script src="../js/app.js"> </script>
    <script>
        let popup = document.querySelector('#modalChangeUserRole')
        popup.show = false;
        let selects = document.querySelectorAll('select');
        let selected;
        let selectedButton;
        let buttons = document.querySelectorAll('.delete-button');

        for (let select of selects) {
            select.addEventListener('change', () => {
                selected = select;
                console.log(selected.getAttribute('data-id'));
            })
        }

        function confirmRole() {
            console.log(selected.value);
            sendAjaxRequest('put', '/admin/user/changeRole', {
                user_id: selected.getAttribute('data-id'),
                role: selected.value
            }, updateRoleHandler);
        }

        function updateRoleHandler() {
            closeOneModal("modalChangeUserRole");
            let alert = document.createElement('div');
            alert.classList.add('alert');
            alert.classList.add('alert-success');
            alert.classList.add('alert-dismissible');
            alert.classList.add('fade');
            alert.classList.add('show');
            alert.setAttribute('role', 'alert');
            alert.innerHTML = '<input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">';
            alert.innerHTML += 'Tipo de utilizador atualizado.';
            let main = document.getElementsByTagName('main')[0];
            main.insertBefore(alert, main.firstChild);
            console.log(main);
        }


        for (let button of buttons) {
            button.addEventListener('click', () => {
                selectedButton = button;
            })
        }

        function deleteUser() {
            sendAjaxRequest('put', '/admin/user/delete', {
                user_id: selectedButton.getAttribute('data-id')
            }, deleteUserHandler);
        }


        function deleteUserHandler() {
            let data = JSON.parse(this.responseText);
            closeOneModal("modalDeleteUser");
            let alert = document.createElement('div');
            alert.classList.add('alert');
            alert.classList.add('alert-danger');
            alert.classList.add('alert-dismissible');
            alert.classList.add('fade');
            alert.classList.add('show');
            alert.setAttribute('role', 'alert');
            alert.innerHTML = '<input type="button" class="btn-close" data-dismiss="alert" aria-label="Close">';
            alert.innerHTML += 'Utilizador Eliminado.';
            let main = document.getElementsByTagName('main')[0];
            main.insertBefore(alert, main.firstChild);
            document.getElementById(data.user_id).remove();
        }

    </script>

    <script>
        function searchUser(event) {
            event.preventDefault();
            let input = document.querySelector('#search-form input');
            sendAjaxRequest('get', `/admin/searchUsers?search=${input.value}`, null, searchUserHandler);
        }

        function searchUserHandler() {

            if (this.status != 200) window.location = '/admin';
            let item = JSON.parse(this.responseText);

            let userRows = document.querySelectorAll('tr');
            userRows.forEach(row => row.remove());

            let table = document.querySelector('tbody');

            item.users.forEach(user => {
                newRow = document.createElement('tr');


                newRow.innerHTML = `<td>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <img src="${user.image_path!=null ? user.image_path : "storage/images/fotoperfil.jpeg"}" class="avatar" alt="Avatar">
                                                ${user.first_name} ${user.last_name }
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            ${user.email}
                                        </td>`;



                if (user.role == 'Basic' || user.role == 'Premium') {
                    newRow.innerHTML += `<td><select class="form-select" data-toggle="modal" data-target="#modalChangeUserRole" data-id="${user.user_id}"
                                                aria-label="Default select example"><option selected value="Basic">Basic</option>
                                                <option value="Editor">Editor</option>
                                                <option value="Admin">Administrator</option></select></td>`
                } else if (user.role == 'Editor') {
                    newRow.innerHTML += `<td><select class="form-select" data-toggle="modal" data-target="#modalChangeUserRole" data-id="${user.user_id}"
                                                aria-label="Default select example"><option value="Basic">Basic</option>
                                                <option selected value="Editor">Editor</option>
                                                <option value="Admin">Administrator</option></select></td>`;
                } else {
                    newRow.innerHTML += `<td><select class="form-select" data-toggle="modal" data-target="#modalChangeUserRole" data-id="${user.user_id}"
                                                aria-label="Default select example"><option value="Basic">Basic</option>
                                                <option value="Editor">Editor</option>
                                                <option selected value="Admin">Administrator</option></select></td>`;
                }



                newRow.innerHTML += `
                                            <td>
                                                <a href="/" class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteUser"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </td>`;

                table.appendChild(newRow);

                let selects = document.querySelectorAll('select');
                let selected;

                for (let select of selects) {
                    select.addEventListener('change', () => {
                        //$("#modalChangeUserRole").modal('toggle')
                        selected = select;
                    })
                }
            });
        }

    </script>
@endsection
