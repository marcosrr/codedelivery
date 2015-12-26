<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\AdminClientRequest;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\ClientService;

class ClientsController extends Controller
{
    private $repository;
    private $userRepository;
    private $clientService;

    public function __construct(ClientRepository $repository, UserRepository $userRepository, ClientService $clientService)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->clientService = $clientService;
    }

    public function index()
    {

        $clients = $this->repository->paginate();
        return view('admin.clients.index', compact('clients'));
    }
    
    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(AdminClientRequest $request)
    {
        $data = $request->all();
        $this->clientService->create($data);
        return redirect()->route('admin.clients.index');
    }

    public function edit($id)
    {
        $client = $this->repository->find($id);
        return view('admin.clients.edit', compact('client'));
    }


    public function update(AdminClientRequest $request, $id)
    {

        $data = $request->all();
        //$this->repository->update($data, $id);
        $this->clientService->update($data, $id);
        return redirect()->route('admin.clients.index');
    }

    public function destroy($id)
    {
        $this->clientService->delete($id);
        return redirect()->route('admin.clients.index');

    }
}
