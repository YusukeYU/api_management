<?php


namespace App\Modules\Account\Controllers;

use App\Core\Http\Controllers\ApiController;
use App\Domains\Account\Entities\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Validator;

class VerificationController extends ApiController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {

        $data = $request->only('token', 'email');

        $validator = Validator::make($data, [
            'email' => 'required|email',
            'token' => 'required|min:255',
        ]);

        if ($validator->fails()) {
            return $this->responseError('Não foi possível validar os dados enviados para verificação do e-mail.
             Tente novamente mais tarde.');
        }

        $User = User::where('email', $data['email'])->first();

        if ($User->hasVerifiedEmail()) {
            return $this->responseError('O e-mail do usuário já foi verificado anteriormente');
        }

        $query = DB::table('email_checks');

        $checkQuery = $query->where('email', $data['email']);

        if (!$emailCheck = $checkQuery->first()) {
            return $this->responseError('Não há nenhum pedido de confirmação pendente.
             Favor gerar um novo pedido.');
        }

        if ($emailCheck->email == $data['email'] && $emailCheck->token == $data['token']) {
            if ($emailCheck->expires_at > Carbon::now()->toDateTimeString()) {
                $User->markEmailAsVerified();
                $checkQuery->where('email', $data['email'])->delete();
            } else {
                return $this->responseError('Seu pedido de confirmação expirou.
                Favor realizar novo pedido de confirmação');
            }
        } else {
            return $this->responseError('Dados de confirmação inválidos.
            Favor gerar um novo pedido de confirmação ou entre em contato com o suporte.');
        }

        event(new Verified($User));

        return $this->responseSuccess('E-mail verificado com sucesso!');
    }

    /**
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            throw ValidationException::withMessages([
                'email' => [trans('verification.user')],
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => [trans('verification.already_verified')],
            ]);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['status' => trans('verification.sent')]);
    }
}
