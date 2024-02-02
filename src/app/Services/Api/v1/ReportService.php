<?php

namespace App\Services\Api\v1;

use App\Models\User;

class ReportService
{
    public function generate(string $startDate, string $endDate, User $user): array
    {
        $profile  = $user->profile()->with('currency')->first();
        $currency = $profile->currency->code;

        $transactions = $user->transactions()
            ->whereBetween('date', [$startDate, $endDate])
            ->with('category')
            ->get();

        $totalIncome   = $transactions->where('category.belongs_to', 'income')->sum('amount');
        $totalExpenses = $transactions->where('category.belongs_to', 'expense')->sum('amount');
        $netIncome     = $totalIncome - $totalExpenses;

        $report = [
            'period_start'   => $startDate,
            'period_end'     => $endDate,
            'currency'       => $currency,
            'transactions'   => $transactions->map(function ($transaction) {
                return [
                    'id'          => $transaction->id,
                    'type'        => $transaction->category->belongs_to,
                    'description' => $transaction->description,
                    'amount'      => $transaction->amount,
                    'category'    => $transaction->category->name,
                    'date'        => $transaction->date,
                ];
            }),
            'total_income'   => $totalIncome,
            'total_expenses' => $totalExpenses,
            'net_income'     => $netIncome,
        ];

        return $report;
    }
}
