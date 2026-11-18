<?php

namespace App\Http\Controllers;

use App\Http\Enums\HttpStatusCode;
use App\Http\Exceptions\AppRuntimeException;
use App\Http\Traits\HttpResponse;
use App\Models\User\UserModel;
use Illuminate\Support\Facades\Auth;

abstract class Controller {
    use HttpResponse;

    protected function getLoggedUser(): ?UserModel {
        $user = Auth::user();

        if ($user === null) {
            throw new AppRuntimeException('USER.INVALID', HttpStatusCode::UNPROCESSABLE_ENTITY);
        }

        return $user;
    }
}
