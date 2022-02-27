<tr id="{{ $user->user_id }}">
    <td>
        <div class="d-flex justify-content-start align-items-center">
            <img src="{{ $user->getAdminAvatar() }}" class="avatar" alt="Avatar">
            {{ $user->first_name . ' ' . $user->last_name }}
        </div>
    </td>
    <td class="align-middle">
        {{ $user->email }}
    </td>
    <td>
        <select class="form-select" data-toggle="modal" data-target="#modalChangeUserRole"
            data-id="{{ $user->user_id }}" aria-label="Default select example">
            @if ($user->role == 'Basic' || $user->role == 'Premium')
                <option selected value="Basic">Basic</option>
                <option value="Editor">Editor</option>
                <option value="Admin">Administrator</option>
            @elseif ($user->role == 'Editor')
                <option value="Basic">Basic</option>
                <option selected value="Editor">Editor</option>
                <option value="Admin">Administrator</option>
            @elseif ($user->role == 'Admin')
                <option value="Basic">Basic</option>
                <option value="Editor">Editor</option>
                <option selected value="Admin">Administrator</option>
            @endif

        </select>

    </td>
    <td>
        <a href="/" class="delete-button btn btn-danger" data-id="{{ $user->user_id }}" data-toggle="modal"
            data-target="#modalDeleteUser"><i class="fas fa-trash-alt"></i></a>
    </td>
</tr>
