<?php

namespace App\Containers\Email\UI\WEB\Controllers;

use App\Containers\Email\UI\API\Requests\ConfirmUserEmailRequest;
use App\Containers\Email\Actions\ValidateConfirmationCodeAction;
use App\Containers\User\Actions\FindUserByIdAction;
use App\Port\Controller\Abstracts\PortWebController;
use Illuminate\Support\Facades\Config;

/**
 * Class Controller.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class Controller extends PortWebController
{

    /**
     * @param \App\Containers\Email\UI\API\Requests\ConfirmUserEmailRequest       $confirmUserEmailRequest
     * @param \App\Containers\User\Actions\FindUserByIdAction              $findUserByIdAction
     * @param \App\Containers\Email\Actions\ValidateConfirmationCodeAction $validateConfirmationCodeAction
     *
     * @return  \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmUserEmail(
        ConfirmUserEmailRequest $confirmUserEmailRequest,
        FindUserByIdAction $findUserByIdAction,
        ValidateConfirmationCodeAction $validateConfirmationCodeAction
    ) {

        // find user by ID
        $user = $findUserByIdAction->run($confirmUserEmailRequest->id);

        // validate the confirmation code and update user status is code is valid
        $validateConfirmationCodeAction->run($user, $confirmUserEmailRequest->code);

        // redirect to the app URL
        return redirect(Config::get('app.url'));
    }

}
