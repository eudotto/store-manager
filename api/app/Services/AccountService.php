<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AccountService
{
    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function create ($data) {
        DB::beginTransaction();

        try {
            $account = Account::create([
                'customer_id' => $data['customer'],
                'credit' => $data['credit'],
                'amount' => $data['value']
            ]);

            Transaction::create([
                'type' => 'credit',
                'value' => $data['value'],
                'description' => 'account opening',
                'account_id' => $account->id
            ]);

            DB::commit();

            return $account;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
