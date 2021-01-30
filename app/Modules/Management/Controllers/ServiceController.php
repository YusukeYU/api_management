<?php
namespace App\Modules\Management\Controllers;

use App\Core\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Validator;
use App\Infrastructure\Repositories\Modules\Management\ServiceRepository;

class ServiceController extends ApiController
{

    private $_nameRepository;

    public function __construct(ServiceRepository $nameRepository)
    {
        $this->_nameRepository = $nameRepository;
    }

    public function postCreateService(Request $request)
    {
        try {
            $data = $request->only(['name', 'price','description']);

            $validator = Validator::make($data, [
                'name' => 'required',
                'price' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->responseError('Favor preencher todos os campos obrigatórios!', $validator->errors());
            }

           $service = $this->_nameRepository->create($data);

        } catch (\Exception $e) {
            return $this->responseSuccess($e->getMessage(), []);
        }

        return $this->responseSuccess("Serviço cadastrado com sucesso!", []);
    }
}
