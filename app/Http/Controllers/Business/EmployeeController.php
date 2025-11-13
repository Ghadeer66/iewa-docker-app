<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\ClientPurchaseCredit;
use App\Models\ClientSubsidy;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function uploadCsv(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
        ]);

        $path = $request->file('file')->getRealPath();
        $handle = fopen($path, 'r');
        if ($handle === false) {
            return back()->withErrors(['file' => 'Unable to read uploaded file.']);
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return back()->withErrors(['file' => 'CSV is empty or invalid.']);
        }

        $normalizedHeader = array_map(fn($h) => strtolower(trim($h)), $header);
        $required = ['name'];
        $personalCodeVariants = ['personal code', 'personal_code', 'personal-code'];
        $hasPersonalCode = false;
        foreach ($personalCodeVariants as $variant) {
            if (in_array($variant, $normalizedHeader, true)) {
                $hasPersonalCode = true;
                break;
            }
        }
        if (!$hasPersonalCode) {
            fclose($handle);
            return back()->withErrors(['file' => 'Missing required column: personal code']);
        }
        foreach ($required as $req) {
            if (!in_array($req, $normalizedHeader, true)) {
                fclose($handle);
                return back()->withErrors(['file' => "Missing required column: {$req}"]);
            }
        }

        $colIndex = [
            'name' => array_search('name', $normalizedHeader, true),
            'personal_code' => null,
        ];
        foreach ($personalCodeVariants as $variant) {
            $idx = array_search($variant, $normalizedHeader, true);
            if ($idx !== false) {
                $colIndex['personal_code'] = $idx;
                break;
            }
        }

        $created = 0;
        $updated = 0;

        DB::beginTransaction();
        try {
            $clientRole = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);

            while (($row = fgetcsv($handle)) !== false) {
                $name = trim($row[$colIndex['name']] ?? '');
                $personalCode = trim($row[$colIndex['personal_code']] ?? '');

                if ($name === '' || $personalCode === '') continue;

                $user = User::where('personal_code', $personalCode)
                    ->first();

                if ($user) {
                    $user->update([
                        'name' => $name,
                        'personal_code' => $personalCode,
                        'position' => $user->position ?: 'employee',
                        'belongs_to' => Auth::id(),
                    ]);
                    $updated++;
                } else {
                    $baseEmail = 'client_' . preg_replace('/[^a-zA-Z0-9]/', '', $personalCode) . '@company.local';
                    $email = $baseEmail;
                    $suffix = 1;
                    while (User::where('email', $email)->exists()) {
                        $suffix++;
                        $email = str_replace('@', "_{$suffix}@", $baseEmail);
                    }

                    $user = User::create([
                        'name' => $name,
                        'email' => $email,
                        'personal_code' => $personalCode,
                        'phone' => rand(1000000000, 9999999999),
                        'password' => Hash::make('password'),
                        'position' => 'employee',
                        'belongs_to' => Auth::id(),
                    ]);

                    // Create wallet for new user
                    Wallet::firstOrCreate([
                        'user_id' => $user->id,
                    ], [
                        'balance' => 0,
                        'type' => 'client',
                    ]);

                    $created++;
                }

                if (!$user->hasRole('client')) {
                    $user->assignRole($clientRole);
                }
            }

            fclose($handle);
            DB::commit();
        } catch (\Throwable $e) {
            fclose($handle);
            DB::rollBack();
            Log::error('Error importing employees', ['error' => $e->getMessage()]);
            return back()->withErrors(['file' => 'خطا در پردازش فایل ']);
        }

        return back()->with('message', "Import completed. Created: {$created}, Updated: {$updated}");
    }

    /**
     * Grant a subsidy (daily limit) via wallet transaction
     */
    public function grantSubsidy(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount'      => ['required', 'integer', 'min:0', 'max:5000000'],
            'percentage'  => ['required', 'integer', 'min:0', 'max:100'],
            'starts_at'   => ['nullable', 'date'],
            'ends_at'     => ['nullable', 'date', 'after_or_equal:starts_at'],
        ]);

        $wallet = $user->wallet()->firstOrCreate(['type' => 'client']);

        WalletTransaction::create([
            'wallet_id'   => $wallet->id,
            'type'        => 'subsidy',
            'amount'      => $validated['amount'],
            'description' => "Subsidy granted ({$validated['percentage']}%)",
            'starts_at'   => $validated['starts_at'] ?? now(),
            'ends_at'     => $validated['ends_at'] ?? now()->addMonth(),
            'granted_by'  => Auth::id(),
        ]);

        return back()->with('message', 'Subsidy granted successfully.');
    }

    /**
     * Grant purchase credit (limit + duration)
     */
    public function grantPurchaseCredit(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount'    => ['required', 'integer', 'min:0', 'max:10000000'],
            'duration'  => ['required', 'integer', 'min:1', 'max:30'], // days
        ]);

        $wallet = $user->wallet()->firstOrCreate(['type' => 'client']);

        WalletTransaction::create([
            'wallet_id'   => $wallet->id,
            'type'        => 'purchase_credit',
            'amount'      => $validated['amount'],
            'description' => "Purchase credit for {$validated['duration']} days",
            'starts_at'   => now(),
            'ends_at'     => now()->addDays($validated['duration']),
            'granted_by'  => Auth::id(),
        ]);

        return back()->with('message', 'Purchase credit granted successfully.');
    }


    public function storeMultipleSubsidy(Request $request)
{
    $validated = $request->validate([
        'client_ids'  => ['required', 'array', 'min:1'],
        'client_ids.*' => ['integer', 'exists:users,id'],
        'max_price'   => ['required', 'integer', 'min:0', 'max:5000000'],
        'starts_at'   => ['nullable', 'date'],
    ]);

    $businessId = Auth::id();
    $businessWallet = Wallet::where('user_id', $businessId)->firstOrFail();

    $totalCost = $validated['max_price'] * count($validated['client_ids']);
    if ($businessWallet->balance < $totalCost) {
        return back()->withErrors(['wallet' => 'موجودی کیف پول کافی برای اعمال این سوبسید وجود ندارد']);
    }

    $startsAt = $validated['starts_at'] ? Carbon::parse($validated['starts_at']) : Carbon::today();
    $endsAt = (clone $startsAt)->addMonth();

    DB::beginTransaction();
    try {
        foreach ($validated['client_ids'] as $clientId) {
            // update or create subsidy record
            ClientSubsidy::updateOrCreate(
                ['user_id' => $clientId],
                [
                    'granted_by' => $businessId,
                    'max_price'  => $validated['max_price'],
                    'starts_at'  => $startsAt,
                    'ends_at'    => $endsAt,
                ]
            );

            $clientWallet = Wallet::firstOrCreate(['user_id' => $clientId]);
            $client = User::find($clientId);

            // Update both wallets
            $businessWallet->decrement('balance', $validated['max_price']);
            $clientWallet->increment('balance', $validated['max_price']);

            // Record transactions for both sides
            WalletTransaction::create([
                'wallet_id' => $businessWallet->id,
                'user_id' => $businessId,
                'type' => 'payment',
                'amount' => $validated['max_price'],
                'description' => 'اعمال سوبسید برای کاربر ' . $client->name,
                'to_wallet_id' => $clientWallet->id,
            ]);

            WalletTransaction::create([
                'wallet_id' => $clientWallet->id,
                'user_id' => $clientId,
                'type' => 'deposit',
                'amount' => $validated['max_price'],
                'description' => 'دریافت سوبسید از ' . Auth::user()->name,
                'to_wallet_id' => $businessWallet->id,
            ]);
        }

        DB::commit();
    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('Error applying subsidy', ['error' => $e->getMessage()]);
        return back()->withErrors(['subsidy' => 'خطا در اعمال سوبسید. لطفا دوباره تلاش کنید.']);
    }

    return back()->with('message', 'سوبسید برای کاربران انتخابی با موفقیت ذخیره شد');
}

    public function storeMultipleCredit(Request $request)
{
    $validated = $request->validate([
        'client_ids' => 'required|array|min:1',
        'client_ids.*' => 'integer|exists:users,id',
        'purchase_credit' => 'required|integer|min:0|max:10000000',
        'starts_at' => 'nullable|date',
    ]);

    $businessId = Auth::id();
    $businessWallet = Wallet::where('user_id', $businessId)->firstOrFail();

    $totalCredit = $validated['purchase_credit'] * count($validated['client_ids']);
    if ($businessWallet->balance < $totalCredit) {
        return back()->withErrors(['wallet' => 'موجودی کیف پول کافی برای اعمال اعتبار وجود ندارد']);
    }

    $startsAt = $validated['starts_at'] ? Carbon::parse($validated['starts_at']) : now();

    DB::beginTransaction();
    try {
        foreach ($validated['client_ids'] as $clientId) {
            // Assign credit to each client
            ClientPurchaseCredit::updateOrCreate(
                ['user_id' => $clientId],
                [
                    'amount' => $validated['purchase_credit'],
                    'valid_days' => 20,
                    'starts_at' => $startsAt,
                ]
            );

            $clientWallet = Wallet::firstOrCreate(['user_id' => $clientId]);
            $client = User::find($clientId);

            // Update both wallets
            $businessWallet->decrement('balance', $validated['purchase_credit']);
            $clientWallet->increment('balance', $validated['purchase_credit']);

            // Record transaction for business (sender)
            WalletTransaction::create([
                'wallet_id' => $businessWallet->id,
                'user_id' => $businessId,
                'type' => 'payment', // money leaving business wallet
                'amount' => $validated['purchase_credit'],
                'description' => 'اعمال اعتبار برای کاربر ' . $client->name,
                'to_wallet_id' => $clientWallet->id,
            ]);

            // Record transaction for client (receiver)
            WalletTransaction::create([
                'wallet_id' => $clientWallet->id,
                'user_id' => $clientId,
                'type' => 'deposit', // money entering client wallet
                'amount' => $validated['purchase_credit'],
                'description' => 'دریافت اعتبار از ' . Auth::user()->name,
                'to_wallet_id' => $businessWallet->id,
            ]);
        }

        DB::commit();
    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('Error applying credit', ['error' => $e->getMessage()]);
        return back()->withErrors(['credit' => 'خطا در اعمال اعتبار: ' . $e->getMessage()]);
    }

    return back()->with('message', 'اعتبارها با موفقیت اعمال شد');
}

}
