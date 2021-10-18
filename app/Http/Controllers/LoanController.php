<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{Loan, User};
use App\Repositories\LoanRepository;
use Validator;

class LoanController extends Controller
{
    protected $loanRepo;

    public function __construct(LoanRepository $loanRepo)
    {
        $this->loanRepo = $loanRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = $this->loanRepo->all();

        return response()->json(
            $this->loanRepo->resourceCollection($loans)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $loan = $this->loanRepo->createLoan($request->all(), $user);
        return response()->json(
            $this->loanRepo->resource($loan)
        );
    }

    /**
     * Display Loan detail
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function getloanDetail(Request $request, Loan $loan)
    {
        return response()->json(
            $this->loanRepo->resource($loan)
        );
    }

    /**
     * Display list of loans from specific user
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function getLoansByUser(User $user)
    {
        $loans = $this->loanRepo->getByUser($user);

        return response()->json(
            $this->loanRepo->resourceCollection($loans)
        );
    }
}
