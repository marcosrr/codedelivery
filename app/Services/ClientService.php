<?php

namespace CodeDelivery\Services;

use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;

class ClientService
{
	
	private $clientRepository;
	private $userRepository;

	public function __construct(ClientRepository $clientRepository, UserRepository $userRepository)
	{
		$this->clientRepository = $clientRepository;
		$this->userRepository = $userRepository;
	}

	public function update(array $data, $id)
	{
		#atualia cliente
		$this->clientRepository->update($data, $id);

		#recupera id do usuario para atualizar os dados do mesmo
		$userId = $this->clientRepository->find($id, ['user_id'])->user_id;

		$this->userRepository->update($data['user'], $userId);
	}

	public function create(array $data)
	{

		#cria senha para usuario
		$data['user']['password'] = bcrypt('123456');

		#grava novo usuario e recupera usuario cadastrado
		$user = $this->userRepository->create($data['user']);

		#seta user_id para o array $data
		$data['user_id'] = $user->id;

		#grava novo cliente
		$this->clientRepository->create($data);
	}

	public function delete($id)
	{

		#recupera id do usuario para exclui-lo
		$userId = $this->clientRepository->find($id, ['user_id'])->user_id;

		#deleta cliente
		$this->clientRepository->delete($id);

		#deleta usuario
		$this->userRepository->delete($userId);
	}
}