<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Http\Requests\HoraCreateRequest;
use Seracademico\Http\Requests\HoraUpdateRequest;
use App\Repositories\HoraRepository;
use App\Validators\HoraValidator;


class HorasController extends Controller
{

    /**
     * @var HoraRepository
     */
    protected $repository;

    /**
     * @var HoraValidator
     */
    protected $validator;


    public function __construct(HoraRepository $repository, HoraValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $horas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $horas,
            ]);
        }

        return view('horas.index', compact('horas'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('horas.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  HoraCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(HoraCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $hora = $this->repository->create($request->all());

            $response = [
                'message' => 'Hora created.',
                'data'    => $hora->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessage()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hora = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $hora,
            ]);
        }

        return view('horas.show', compact('hora'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $hora = $this->repository->find($id);

        return view('horas.edit', compact('hora'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  HoraUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(HoraUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $hora = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Hora updated.',
                'data'    => $hora->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessage()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Hora deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Hora deleted.');
    }
}
