<?php

namespace App\Http\Controllers;

use App\Models\{Repayment, Loan};
use App\Repositories\RepaymentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RepaymentController extends Controller
{
    protected $repaymentRepo;


    public function __construct(RepaymentRepository $repaymentRepo)
    {
        $this->repaymentRepo = $repaymentRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repayments = $this->repaymentRepo->all();

        return response()->json(
            $this->repaymentRepo->resourceCollection($repayments)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Loan $loan)
    {
        try {
            $repayment = $this->repaymentRepo->createRepayment($request->all(), $loan);

            return response()->json(
                $this->repaymentRepo->resource($repayment)
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Resource not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Display repayment detail.
     *
     * @param  \App\Repayment  $repayment
     * @return \Illuminate\Http\Response
     */
    public function getRepaymentDetail(Repayment $repayment)
    {
        return response()->json(
            $this->repaymentRepo->resource($repayment)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Repayment  $repayment
     * @return \Illuminate\Http\Response
     */
    public function delete(Repayment $repayment)
    {
        $this->repaymentRepo->delete($repayment);
        return response()->json(null, 204);
    }
}
