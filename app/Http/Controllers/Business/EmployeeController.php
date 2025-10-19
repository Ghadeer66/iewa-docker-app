<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
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

		$normalizedHeader = array_map(function ($h) {
			return strtolower(trim($h));
		}, $header);

		// Required columns (support variants for personal code)
		$required = ['name', 'phone'];
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
			'phone' => array_search('phone', $normalizedHeader, true),
			'personal_code' => null,
		];
		foreach ($personalCodeVariants as $variant) {
			$idx = array_search($variant, $normalizedHeader, true);
			if ($idx !== false) { $colIndex['personal_code'] = $idx; break; }
		}

		$created = 0;
		$updated = 0;

		DB::beginTransaction();
		try {
			$clientRole = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);

			while (($row = fgetcsv($handle)) !== false) {
				$name = trim($row[$colIndex['name']] ?? '');
				$phone = trim($row[$colIndex['phone']] ?? '');
				$personalCode = trim($row[$colIndex['personal_code']] ?? '');

				if ($name === '' || $phone === '' || $personalCode === '') {
					continue; // skip invalid rows
				}

				$user = User::where('phone', $phone)
					->orWhere('personal_code', $personalCode)
					->first();

				if ($user) {
					$user->fill([
						'name' => $name,
						'phone' => $phone,
						'personal_code' => $personalCode,
						'position' => $user->position ?: 'employee',
						'belongs_to' => Auth::id(),
					]);
					$user->save();
					$updated++;
				} else {
					// Generate placeholder unique email to satisfy NOT NULL + UNIQUE constraint
					$base = preg_replace('/[^a-zA-Z0-9]/', '', ($personalCode !== '' ? $personalCode : $phone));
					$baseEmail = 'client_' . ($base ?: uniqid()) . '@company.local';
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
						'phone' => $phone,
						'password' => Hash::make(str()->random(12)),
						'position' => 'employee',
						'belongs_to' => Auth::id(),
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
			return back()->withErrors(['file' => 'Import failed: '.$e->getMessage()]);
		}

		return back()->with('message', "Import completed. Created: {$created}, Updated: {$updated}");
	}

	public function setSubsidy(Request $request, User $user)
	{
		$validated = $request->validate([
			'percentage' => ['required', 'integer', 'min:1', 'max:100'],
			'starts_at' => ['nullable', 'date'],
			'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
		]);

		DB::table('client_subsidies')->updateOrInsert(
			['user_id' => $user->id],
			[
				'percentage' => $validated['percentage'],
				'starts_at' => $validated['starts_at'] ?? null,
				'ends_at' => $validated['ends_at'] ?? null,
				'granted_by' => Auth::id(),
				'updated_at' => now(),
				'created_at' => now(),
			]
		);

		return back()->with('message', 'Subsidy saved for user.');
	}

	public function setSubsidyByCode(Request $request)
	{
		$validated = $request->validate([
			'personal_code' => ['required', 'string'],
			'percentage' => ['required', 'integer', 'min:1', 'max:100'],
			'starts_at' => ['nullable', 'date'],
			'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
		]);

		$user = User::where('personal_code', $validated['personal_code'])->first();
		if (!$user) {
			return back()->withErrors(['personal_code' => 'کاربری با این کد پرسنلی یافت نشد']);
		}

		DB::table('client_subsidies')->updateOrInsert(
			['user_id' => $user->id],
			[
				'percentage' => $validated['percentage'],
				'starts_at' => $validated['starts_at'] ?? null,
				'ends_at' => $validated['ends_at'] ?? null,
				'granted_by' => Auth::id(),
				'updated_at' => now(),
				'created_at' => now(),
			]
		);

		return back()->with('message', 'Subsidy saved for user.');
	}
}
