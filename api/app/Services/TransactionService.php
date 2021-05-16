<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use App\Services\Exceptions\AccountDestinationNotFoundException;
use App\Services\Exceptions\AccountNotFoundException;
use App\Services\Exceptions\InsufficientFundsException;
use App\Services\Exceptions\OriginEqualDestinationException;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    /**
     * @param $accountId
     * @param int $perPage
     * @return mixed
     */
    public function listByAccountId($accountId, $perPage = 15)
    {
        return Transaction::where('account_id', $accountId)->paginate($perPage);
    }

    /**
     * @param $data
     * @return mixed
     * @throws AccountNotFoundException
     */
    public function credit($data)
    {
        DB::beginTransaction();
        try {
            $data['description'] = 'deposit on account';
            $transaction = Transaction::create($data);
            $account = Account::find($data['account_id']);

            if (is_null($account)) {
                throw new AccountNotFoundException();
            }

            $account->fill(['amount' => $account->amount + $data['value']]);
            $account->save();

            DB::commit();
            return $transaction;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param $data
     * @return mixed
     * @throws AccountNotFoundException
     * @throws InsufficientFundsException
     */
    public function debit($data)
    {
        DB::beginTransaction();
        try {
            $data['description'] = 'withdrawal on account';
            $transaction = Transaction::create($data);
            /** @var Account $account */
            $account = Account::find($data['account_id']);

            if (is_null($account)) {
                throw new AccountNotFoundException();
            }

            if ($data['value'] > ($account->amount + $account->credit)) {
                throw new InsufficientFundsException();
            }

            $account->fill(['amount' => $account->amount - $data['value']]);
            $account->save();

            DB::commit();
            return $transaction;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param $data
     * @return array
     * @throws AccountDestinationNotFoundException
     * @throws AccountNotFoundException
     * @throws InsufficientFundsException
     * @throws OriginEqualDestinationException
     */
    public function transfer($data)
    {
        DB::beginTransaction();
        try {
            $accountOrigin = Account::find($data['account_id']);
            if (is_null($accountOrigin)) {
                throw new AccountNotFoundException();
            }

            $accountDestination = Account::find($data['account_destination']);
            if (is_null($accountDestination)) {
                throw new AccountDestinationNotFoundException();
            }

            if ($accountOrigin->id ===$accountDestination->id) {
                throw new OriginEqualDestinationException();
            }

            if ($data['value'] > ($accountOrigin->amount + $accountOrigin->credit)) {
                throw new InsufficientFundsException();
            }

            $transactionOrigin = Transaction::create([
                'type' => 'debit',
                'description' => "transferred to account: {$accountDestination->id}",
                'value' => $data['value'],
                'account_id' => $accountOrigin->id
            ]);

            $transactionDestination = Transaction::create([
                'type' => 'credit',
                'description' => "transferred from account: {$accountOrigin->id}",
                'value' => $data['value'],
                'account_id' => $accountDestination->id
            ]);

            $accountOrigin->fill(['amount' => $accountOrigin->amount - $data['value']]);
            $accountOrigin->save();

            $accountDestination->fill(['amount' => $accountDestination->amount + $data['value']]);
            $accountDestination->save();

            DB::commit();

            return [
                'origin' => $transactionOrigin,
                'destination' => $transactionDestination
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
