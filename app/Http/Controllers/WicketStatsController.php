<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\WicketStatCreateRequest;
use App\Http\Requests\WicketStatUpdateRequest;
use App\Repositories\WicketStatRepository;
use App\Validators\WicketStatValidator;

/**
 * Class WicketStatsController.
 *
 * @package namespace App\Http\Controllers;
 */
class WicketStatsController extends Controller
{
    /**
     * @var WicketStatRepository
     */
    protected $repository;

    /**
     * @var WicketStatValidator
     */
    protected $validator;

    /**
     * WicketStatsController constructor.
     *
     * @param WicketStatRepository $repository
     * @param WicketStatValidator $validator
     */
    public function __construct(WicketStatRepository $repository, WicketStatValidator $validator)
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
        $wicketStats = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $wicketStats,
            ]);
        }

        return view('wicketStats.index', compact('wicketStats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WicketStatCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(WicketStatCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $wicketStat = $this->repository->create($request->all());

            $response = [
                'message' => 'WicketStat created.',
                'data'    => $wicketStat->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
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
        $wicketStat = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $wicketStat,
            ]);
        }

        return view('wicketStats.show', compact('wicketStat'));
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
        $wicketStat = $this->repository->find($id);

        return view('wicketStats.edit', compact('wicketStat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WicketStatUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(WicketStatUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $wicketStat = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'WicketStat updated.',
                'data'    => $wicketStat->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
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
                'message' => 'WicketStat deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'WicketStat deleted.');
    }
}
