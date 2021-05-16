<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\Exceptions\AccountDestinationNotFoundException;
use App\Services\Exceptions\AccountNotFoundException;
use App\Services\Exceptions\EntityNotFoundException;
use App\Services\Exceptions\InsufficientFundsException;
use App\Services\Exceptions\OriginEqualDestinationException;
use App\Services\Exceptions\ServiceException;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->entity = Transaction::class;
    }

    public function listByAccount(int $accountId, Request $request)
    {
        $transactionService = new TransactionService();
        return $transactionService->listByAccountId($accountId, $request->per_page);
    }

    public function create(Request $request)
    {
        $rules = [
            'type' => 'required|in:transfer,credit,debit',
            'value' => 'required|numeric|min:1|max:99999999.99',
            'account_id' => 'required|integer'
        ];

        if ($request->post('type') === 'transfer') {
            $rules['account_destination'] = 'required|integer';
        }

        $this->validate($request, $rules);
        $data = $request->all();

        try {
            $transactionService = new TransactionService();
            switch ($data['type']) {
                case 'credit':
                    $transaction = $transactionService->credit($data);
                    break;
                case 'debit':
                    $transaction = $transactionService->debit($data);
                    break;
                case 'transfer':
                    $transaction = $transactionService->transfer($data);
                    break;
                default:
                    $transaction = false;
            }

            if (!$transaction) {
                return response()->json([
                    'error' => 'Transaction type error'
                ], 422);
            }

            return response()
                ->json(
                    $transaction,
                    201
                );
        } catch (EntityNotFoundException $exception) {
            return response()->json([
                'error' => 'Entity not found'
            ], 404);
        } catch (AccountNotFoundException $exception) {
            return response()->json([
                'error' => 'Account not found'
            ], 404);
        } catch (AccountDestinationNotFoundException $exception) {
            return response()->json([
                'error' => 'Account Destination not found'
            ], 404);
        } catch (OriginEqualDestinationException $exception) {
            return response()->json([
                'error' => 'Account of the destination can not equal origin account'
            ], 422);
        }
        catch (InsufficientFundsException $e) {
            return response()->json([
                'error' => 'Insufficient Funds'
            ], 422);
        } catch (ServiceException $e) {
            return response()->json([
                'error' => 'Service error'
            ], 422);
        }
    }

    public function update(int $id, Request $request)
    {
        return response()->json([
            'error' => 'Method not allowed'
        ], 405);
    }

    public function destroy(int $id)
    {
        return response()->json([
            'error' => 'Method not allowed'
        ], 405);
    }


}
